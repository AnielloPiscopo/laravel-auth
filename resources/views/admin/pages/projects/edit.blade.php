@extends('layouts.app')

@section('content')
@include('admin.pages.projects.partials.form',["route" => "admin.pages.projects.update"  , "formMethod" => "PUT" , "project" => $project])
@endsection