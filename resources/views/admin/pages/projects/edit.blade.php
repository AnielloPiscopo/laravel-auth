@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '- Projects')

@section('content')
@include('admin.pages.projects.partials.form',["route" => "admin.pages.projects.update"  , "formMethod" => "PUT" , "project" => $project])
@endsection