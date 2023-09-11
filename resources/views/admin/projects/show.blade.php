@extends('layouts.app')

@section('title', "$project->title")

@section('content')
    @include('includes.alert')
    <div class="card mt-5 bg-light p-5">
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
        <div class="card-body row justify-content-between ">
            <div class="col-4 mt-3">
                <img class="col-4 w-100" src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            </div>
            <div class="col-8 ps-5">
                <p>
                    {{ $project->description }}
                </p>
                <ul>
                    <li>
                        <strong>Repository name:</strong> {{ $project->slug }}
                    </li>
                    <li>
                        <strong>Category:</strong> {{ $project->type ? $project->type->label : 'None' }}
                    </li>
                    <li class="my-2">
                        <strong>Technologies: </strong>
                        @forelse ($project->technologies as $technology)
                            <span
                                class="bg-{{ $technology->color }} rounded py-1 px-2 text-white">{{ $technology->label }}</span>
                        @empty
                            -
                        @endforelse
                    </li>
                    <li>
                        <strong>Stars:</strong>
                        @for ($i = 0; $i < $project->n_stars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between mt-3 align-items-center border-0 bg-light">
            <div class="buttons d-flex">
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning mx-2">
                    <i class="fas fa-pen me-2"></i>Edit
                    project
                </a>
                <form class="delete-form" action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                    data-name="{{ $project->title }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete project
                    </button>
                </form>
            </div>
            <div class="text-end">
                <strong>Creazione:</strong> {{ $project->created_at }} <br>
                <strong>Ultima Modifica:</strong> {{ $project->updated_at }}
            </div>
        </div>
    </div>
    <footer class="text-center mb-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mx-2 mt-5">Go back to the projects list</a>
    </footer>
@endsection

@section('scripts')
    @vite('resources/js/delete-confirm.js');
@endsection
