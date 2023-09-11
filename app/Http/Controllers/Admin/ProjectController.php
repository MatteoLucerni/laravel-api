<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');

        $query = Project::orderBy('updated_at', 'DESC');

        if ($filter) $query->where('type_id', $filter);

        $projects = $query->paginate(10);

        $types = Type::select('id', 'label')->get();

        return view('admin.projects.index', compact('projects', 'types', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::select('id', 'label')->get();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|unique:projects',
                'image' => 'image:jpg,jpeg,png|nullable',
                'description' => 'string|nullable',
                'n_stars' => 'numeric|nullable|gt:0',
                'is_public' => 'boolean|nullable',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'The title of the project is required',
                'title.unique' => 'The title alredy exists, must be unique',
                'n_stars.numeric' => 'You must insert a positive number',
                'image.image' => 'The file is not valid',
                'type_id.exists' => 'This category does not exist',
                'technologies.exists' => 'This technology does not exist'
            ]
        );

        $data = $request->all();
        $project = new Project($data);

        if (array_key_exists('image', $data)) {
            $ext = $data['image']->extension();
            $img_url = Storage::putFileAs('project_images', $data['image'], "{$data['slug']}.$ext");
            $data['image'] = $img_url;
        }

        $project->slug = Str::slug($project->title, '-');

        $project->fill($data);
        $project->save();

        if (array_key_exists('technologies', $data)) $project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.show', $project)->with('alert-message', "Project '$project->title' created successfully")->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::select('id', 'label')->get();
        $technologies = Technology::all();

        $project_technology_ids = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technology_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');


        if (array_key_exists('image', $data)) {
            if ($project->image) Storage::delete($project->image);
            $ext = $data['image']->extension();
            $img_url = Storage::putFile('project_images', $data['image'], "{$data['slug']}.$ext");
            $data['image'] = $img_url;
        }

        $project->update($data);

        if (!Arr::exists($data, 'technologies') && count($project->technologies)) $project->technologies()->detach();
        elseif (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);

        return to_route('admin.projects.show', $project)->with('alert-message', "Project '$project->title' edited successfully")->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('admin.projects.index')->with('alert-message', "Project '$project->title' moved to trash successfully")->with('alert-type', 'success');
    }

    // trash

    public function trash()
    {
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }

    public function dropAll()
    {
        Project::onlyTrashed()->forceDelete();
        return to_route('admin.projects.trash')->with('alert-message', "All projects in the trash deleted successfully")->with('alert-type', 'success');
    }

    public function drop(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        if (!$project) return to_route('admin.projects.index')->with('alert-message', "Project not found")->with('alert-type', 'danger');

        if ($project->image) Storage::delete($project->image);

        if (count($project->technologies)) $project->technologies()->detach();

        $project->forceDelete();

        return to_route('admin.projects.trash')->with('alert-message', "Project '$project->title' deleted successfully")->with('alert-type', 'success');
    }


    public function restore(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $project->restore();

        return to_route('admin.projects.trash')->with('alert-message', "Project '$project->title' restored successfully")->with('alert-type', 'success');
    }
}
