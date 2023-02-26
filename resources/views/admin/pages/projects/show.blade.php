{{-- 
|--------------------------------------------------------------------------
| Project show in Admin
|--------------------------------------------------------------------------
|
| This is the show 'Project' section of the website
| available to the Admin.
|
--}}

@extends('layouts.app')

@section('title' , config('app.name', 'Laravel') . '- Projects')

@section('content')
@php
    $listElements = [
        'title',
        'description',
    ]
@endphp

<article class="my_card">
    <div class="card-image mb-4">
        @if ( $project->isImageAUrl())
        <img src="{{ $project->img_path }}"
        @else
        <img src="{{ asset("storage/$project->img_path") }}"
        @endif
        alt="{{ $project->title }} image" class="img-fluid">
    </div>

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

    <div class="my_btn-container">
        
    </div>
</article>
@endsection