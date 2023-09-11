<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter');

        $query = Project::orderBy('updated_at', 'DESC');

        if ($filter) $query->where('type_id', $filter);

        $projects = $query->paginate(10);

        $types = Type::select('id', 'label')->get();

        return view('guest.home', compact('projects', 'types', 'filter'));
    }
}
