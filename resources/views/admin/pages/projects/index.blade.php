{{-- 
|--------------------------------------------------------------------------
| Project index in Admin
|--------------------------------------------------------------------------
|
| This is the index 'Project' section of the website
| available to the Admin.
|
--}}

@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '- Projects')

@section('content')
@include('admin.pages.projects.partials.tableContainer' , ["projects" => $projects , "title" => "List Of My Projects" , "projectsRoute" => "index"])
@endsection