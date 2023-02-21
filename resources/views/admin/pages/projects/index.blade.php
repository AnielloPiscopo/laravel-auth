@extends('layouts.app')

@section('content')
@php
$tableElements=[
    'Id',
    'Title',
    'Description',
    '#'
];    
@endphp 

@if (session('message'))
    <span>{{session('message')}}</span>
@endif

<table class="table table-hover">
    <thead class="table-dark">
      <tr>
        @foreach ($tableElements as $tableEl)
            <th scope="col">{{$tableEl}}</th>
        @endforeach
      </tr>
    </thead>

    <tbody>
      @foreach ($projects as $project)
        <tr>
            <th scope="row">{{$project->id}}</th>
            <td>{{$project->title}}</td>
            <td>{{$project->description}}</td>
            <td>
                <a href="{{route('admin.pages.projects.show' , $project->slug)}}" class="my_btn btn btn-primary">Show</a>
                <a href="{{route('admin.pages.projects.edit' , $project->slug)}}" class="my_btn btn btn-dark">Edit</a>

                <form action="{{route('admin.pages.projects.destroy' , $project->slug)}}" method="POST" data-form-destroy data-element-name = '{{$project->title}}' >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="my_btn btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $projects->links() }}
@endsection