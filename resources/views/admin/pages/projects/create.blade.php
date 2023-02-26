{{-- 
|--------------------------------------------------------------------------
| Project create in Admin
|--------------------------------------------------------------------------
|
| This is the create 'Project' section of the website
| available to the Admin.
|
--}}

@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '- Projects')

@section('content')
@include('admin.pages.projects.partials.form',["route" => "admin.pages.projects.store"  , "formMethod" => "POST"])
@endsection