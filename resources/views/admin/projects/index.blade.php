@extends('layouts.app')

@section('title', 'Admin: Projects List')


@section('content')

    <h1 class="text-center mt-5">List of Projects</h1>
    @include('includes.alert')
    <div class="d-flex justify-content-between">
        <div class="d-flex align-items-end">
            <form action="{{ route('admin.projects.index') }}" method="GET">
                <div class="input-group">
                    <button class="btn btn-outline-success" type="submit">Filtra</button>
                    <select class="form-select" name="filter" id="filter">
                        <option value="gg">None</option>
                        @foreach ($types as $type)
                            <option @if ($filter == $type->id) selected @endif value="{{ $type->id }}">
                                {{ $type->label }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <form action="{{ route('admin.projects.index') }}" method="GET">
                <button class="btn btn-outline-secondary ms-3" type="submit">Reset filter</button>
            </form>
        </div>
        <div class="d-flex justify-content-end mt-5">
            <a class="d-inline-block btn btn-secondary me-2" href="{{ route('admin.projects.trash') }}">Open trash</a>
            <a class="d-inline-block btn btn-success" href="{{ route('admin.projects.create') }}">Create a new
                project</a>
        </div>
    </div>
    <ul class="list-unstyled">
        @forelse ($projects as $project)
            <li class="my-5">
                <div class="card bg-light p-5">
                    <div class="card-header rounded border-0 mb-4 d-flex justify-content-between align-content-center">
                        <h2 class="m-0 d-flex align-items-center">
                            {{ $project->title }}
                        </h2>
                        <div class="d-flex">
                            @if ($project->type)
                                <p style="border: 1px solid {{ $project->type->color }}; color: {{ $project->type->color }}"
                                    class="d-flex rounded align-items-center m-0 px-3">
                                    {{ $project->type->label }}</p>
                            @else
                                <p style="background-color: lightgray"
                                    class="d-flex rounded border border-dark align-items-center m-0 px-3">
                                    None</p>
                            @endif
                            @if ($project->is_public)
                                <div class="alert alert-success m-0 ms-2">
                                    Open-source
                                </div>
                            @else
                                <div class="alert alert-danger m-0 ms-2">
                                    Private-source
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="">
                            {{ $project->description }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between mt-3 align-items-center border-0 bg-light">
                        <div class="buttons d-flex">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>More details
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning mx-2">
                                <i class="fas fa-pen me-2"></i>Edit
                                project
                            </a>
                            <form class="delete-form" action="{{ route('admin.projects.destroy', $project) }}"
                                method="POST" data-name="{{ $project->title }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete project
                                </button>
                            </form>
                        </div>
                        <div class="text-end">
                            Creazione: {{ $project->created_at }} <br>
                            Ultima Modifica: {{ $project->updated_at }}
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <h4 class="alert alert-danger mt-5 text-center">Non ci sono progetti disponibili</h4>
        @endforelse
    </ul>
    @if ($projects->hasPages())
        {{ $projects->links() }}
    @endif
@endsection

@section('scripts')
    @vite('resources/js/delete-confirm.js');
@endsection
