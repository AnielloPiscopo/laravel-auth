<form action="{{route($route , $project->id)}}" method="POST">
  @csrf
  @method($formMethod)

  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input class="form-control my_form-el" id="title" name="title" aria-describedby="title-errors" placeholder="Insert the title" minlength="2" maxlength="255" value="{{old('title',$project->title)}}">
    <div id="title-errors" class="form-text">We'll never share your email with anyone else.</div>
  </div>

  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control my_form-el" id="description" cols="30" rows="10" name="description" aria-describedby="description-errors" minlength="10" placeholder="Insert the description">{{old('description',$project->description)}}</textarea>
    <div id="description-errors" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <button type="submit" class="btn btn-primary my_btn">Submit</button>
</form>