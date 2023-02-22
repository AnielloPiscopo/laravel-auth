@php
$tableElements=[
    'Id',
    'Title',
    'Description',
    '#Actions'
];    
@endphp

<section class="card container">
  <div class="card-header">
    <div class="row align-items-center">
      <div class="col-6">
        <h2 class="my_title fw-bold">{{$title}}</h2>
      </div>

      <div class="col-6">
        <div class="text-end">
          {{-- @if ($numOfTrashedElements)
          <a href="{{route('admin.pages.projects.trashed')}}" class="my_btn btn btn-outline-danger" title="{{$numOfTrashedElements>1 ? "$numOfTrashedElements trashed elements" : "1 trashed element"}}">Go to the the recycled bin</a>
          @endif --}}
          <a href="{{route('admin.pages.projects.create')}}" class="my_btn btn btn-outline-primary">Add a new project +</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card-body">
    @if (session('message'))
    <div>{{session('message')}}</div>
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
              <td class="">
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

    {{-- <div class="my_pagination-links d-flex justify-content-end">
      {{ $projects->links() }}
    </div> --}}
  </div>
</section>