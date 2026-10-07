@extends('layouts.admin')

@section('title', 'Add Project')
@section('heading', 'Add project')
@section('subheading', 'Create a new entry for your portfolio')

@section('content')
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.projects._form')
    </form>
@endsection
