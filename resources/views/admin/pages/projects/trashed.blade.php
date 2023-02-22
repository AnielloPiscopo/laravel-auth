@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '-  Trashed Projects')

@section('content')
@include('admin.pages.projects.partials.tableContainer' , ["projects" => $trashedProjects , "title" => "List Of Trashed Projects"])
@endsection