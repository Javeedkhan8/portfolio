@extends('layouts.admin')

@section('title', 'Edit Experience')
@section('heading', 'Edit experience')
@section('subheading', $experience->job_title)

@section('content')
    <form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
        @csrf
        @method('PUT')
        @include('admin.experiences._form')
    </form>
@endsection
