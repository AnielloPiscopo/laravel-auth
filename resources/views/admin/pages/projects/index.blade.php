@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '- Projects')

@section('content')
@include('admin.pages.projects.partials.tableContainer' , ["projects" => $projects , "title" => "List Of My Projects"])
@endsection