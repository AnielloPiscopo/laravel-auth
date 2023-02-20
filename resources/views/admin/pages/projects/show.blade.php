@extends('layouts.app')

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
</article>
@endsection