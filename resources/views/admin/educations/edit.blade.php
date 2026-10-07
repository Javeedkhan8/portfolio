@extends('layouts.admin')

@section('title', 'Edit Education')
@section('heading', 'Edit education')
@section('subheading', $education->degree)

@section('content')
    <form method="POST" action="{{ route('admin.educations.update', $education) }}">
        @csrf
        @method('PUT')
        @include('admin.educations._form')
    </form>
@endsection
