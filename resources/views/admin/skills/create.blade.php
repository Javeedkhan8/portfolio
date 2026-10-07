@extends('layouts.admin')

@section('title', 'Add Skill')
@section('heading', 'Add skill')
@section('subheading', 'Add a technology to your toolkit')

@section('content')
    <form method="POST" action="{{ route('admin.skills.store') }}">
        @csrf
        @include('admin.skills._form')
    </form>
@endsection
