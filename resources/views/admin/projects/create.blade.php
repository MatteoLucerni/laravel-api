@extends('layouts.app')

@section('title', 'Create new project')

@section('content')
    <h1 class="text-center mt-5">Create a new project</h1>
    @include('includes.form')
    <div class="d-flex justify-content-center my-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Go back</a>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/slug-gen.js')
@endsection
