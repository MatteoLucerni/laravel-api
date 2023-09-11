@extends('layouts.app')

@section('title', "Edit $project->title")

@section('content')
    <h1 class="text-center mt-5">Edit project: {{ $project->title }}</h1>
    @include('includes.form')
    <div class="d-flex justify-content-center my-5">
        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary">Go back</a>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/slug-gen.js')
@endsection
