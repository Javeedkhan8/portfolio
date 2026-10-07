@extends('layouts.admin')

@section('title', 'Edit Skill')
@section('heading', 'Edit skill')
@section('subheading', $skill->name)

@section('content')
    <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
        @csrf
        @method('PUT')
        @include('admin.skills._form')
    </form>
@endsection
