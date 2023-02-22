@if ($errors->any())
    <div class="alert alert-danger">
      <h3>Check Errors</h3>
    </div>
@endif

<form action="{{route($route , $project->slug)}}" method="POST">
  @csrf
  @method($formMethod)

  <article class="card">
    <div class="card-header">
      <h2 class="text-center m-0 p-3 fw-bold">{{$formMethod === 'POST' ? 'Create a new project' : "Edit the project '$project->title'"}}</h2>
    </div>
    <div class="card-body">
      <div class="form-outline mb-3">
        <label for="title" class="form-label">Title</label>
        <input class="my_form-el form-control @error('title') is-invalid @enderror" id="title" name="title" aria-describedby="title-errors" placeholder="Insert the title" minlength="2" maxlength="255" value="{{old('title',$project->title)}}">
        @error('title')
        <div class="form-text invalid-feedback">{{$message}}</div>
        @enderror
      </div>
    
      <div class="form-outline mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="my_form-el form-control  @error('descripttion') is-invalid @enderror"" id="description" cols="30" rows="10" name="description" aria-describedby="description-errors" minlength="10" placeholder="Insert the description">{{old('description',$project->description)}}</textarea>
        @error('description')
        <div class="form-text invalid-feedback">{{$message}}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary my_btn">Submit</button>
    </div>
  </article>
</form>