@extends('layouts.app')

@section('title', 'Trash')


@section('content')
    <h1 class="text-center mt-5">Projects trash</h1>
    @include('includes.alert')
    <div class="d-flex justify-content-end mt-5">
        <form class="delete-form" action="{{ route('admin.projects.dropAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>Delete all
            </button>
        </form>
    </div>
    <ul class="list-unstyled">
        @forelse ($projects as $project)
            <li class="my-5">
                <div class="card bg-light p-5">
                    <div class="card-header rounded border-0 mb-4 d-flex justify-content-between align-content-center ">
                        <h2 class="m-0 d-flex align-items-center">
                            {{ $project->title }}
                        </h2>
                        @if ($project->is_public)
                            <div class="alert alert-success m-0">
                                Open-source
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="">
                            {{ $project->description }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between mt-3 align-items-center border-0 bg-light">
                        <div class="buttons d-flex">
                            <form class="me-2" action="{{ route('admin.projects.restore', $project) }}" method="POST"
                                data-name="{{ $project->title }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success">
                                    <i class="fas fa-arrow-rotate-left me-2"></i>Restore project
                                </button>
                            </form>
                            <form class="delete-form" action="{{ route('admin.projects.drop', $project) }}" method="POST"
                                data-name="{{ $project->title }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete project
                                </button>
                            </form>
                        </div>
                        <div class="text-end">
                            Created: {{ $project->created_at }} <br>
                            Last edit: {{ $project->updated_at }} <br>
                            Deleted: {{ $project->deleted_at }}
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <h4 class="alert alert-danger mt-5 text-center">Trash is empty</h4>
        @endforelse
    </ul>
    <footer class="text-center mb-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mx-2 mt-5">Go back to the projects list</a>
    </footer>
@endsection

@section('scripts')
    @vite('resources/js/delete-confirm.js');
@endsection
