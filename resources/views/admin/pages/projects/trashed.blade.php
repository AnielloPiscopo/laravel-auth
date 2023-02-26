{{-- 
|--------------------------------------------------------------------------
| Project trashed in Admin
|--------------------------------------------------------------------------
|
| This is the trashed 'Project' section of the website
| available to the Admin.
|
--}}

@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '-  Trashed Projects')

@section('content')
@include('admin.pages.projects.partials.tableContainer' , ["projects" => $trashedProjects , "title" => "List Of Trashed Projects" , "projectsRoute" => 'trashed'])
@endsection