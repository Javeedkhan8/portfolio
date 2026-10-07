@extends('layouts.admin')

@section('title', 'Add Education')
@section('heading', 'Add education')
@section('subheading', 'Add a qualification to your academic background')

@section('content')
    <form method="POST" action="{{ route('admin.educations.store') }}">
        @csrf
        @include('admin.educations._form')
    </form>
@endsection
