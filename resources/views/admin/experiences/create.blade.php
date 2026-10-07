@extends('layouts.admin')

@section('title', 'Add Experience')
@section('heading', 'Add experience')
@section('subheading', 'Add a role to your work history')

@section('content')
    <form method="POST" action="{{ route('admin.experiences.store') }}">
        @csrf
        @include('admin.experiences._form')
    </form>
@endsection
