@extends('layouts.admin')

@section('title', 'Edit Project')
@section('heading', 'Edit project')
@section('subheading', $project->title)

@section('content')
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.projects._form')
    </form>
@endsection
