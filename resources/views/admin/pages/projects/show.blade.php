@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '- Projects')

@section('content')
@php
    $listElements = [
        'title',
        'description',
    ]
@endphp

@if (session('message'))
    <span>{{session('message')}}</span>
@endif

<article class="my_card">    
    <ul>
        @foreach ($listElements as $listEl)
            <li>{{$listEl . ':' . $project->$listEl}}</li> 
        @endforeach
    </ul>

    <div class="my_btn-container d-flex justify-content-center">
        <a href="{{route('admin.pages.projects.edit' , $project->slug)}}" class="my_btn btn btn-dark">Edit</a>

        <form action="{{route('admin.pages.projects.destroy' , $project->slug)}}" method="POST" data-form-destroy data-element-name = '{{$project->title}}' >
            @csrf
            @method('DELETE')
            <button type="submit" class="my_btn btn btn-danger">Delete</button>
        </form>
    </div>
</article>
@endsection