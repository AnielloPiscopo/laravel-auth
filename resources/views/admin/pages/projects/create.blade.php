@extends('layouts.app')

@section('content')
@include('admin.pages.projects.partials.form',["route" => "admin.pages.projects.store"  , "formMethod" => "POST" , "project" => $project])
@endsection