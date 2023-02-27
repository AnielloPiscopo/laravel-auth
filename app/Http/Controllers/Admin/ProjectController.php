<?php

/*
|--------------------------------------------------------------------------
| Project Controller in Admin
|--------------------------------------------------------------------------
|
| A controller for the istance Project
|
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Console\View\Components\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use NumberFormatter;
use RealRashid\SweetAlert\Facades\Alert;

class ProjectController extends Controller
{
    protected $rules = [
        'title' => 'required|string|unique:projects|between:2,255',
        'description' => 'required|min:10',
        'slug' => 'string|unique:projects|between:2,255',
        'img_path' => 'required|unique:projects|image|max:300',
    ];

    protected $messages = [
        'title.required' => 'Il titolo deve essere inserito obbligatoriamente',
        'description.min' => 'La descrizione non è abbastanza lunga(min=10 caratteri)',
        'title.between' => 'Il titolo deve avere un numero di caratteri compreso tra 2 e 255',
        'img_path.image' => "Il file inserito deve essere un'immagine",
        'img_path.max' => "L'immagine non deve superare i 300 kb",
    ];
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $numOfElementsToView = 10;
        $orderCondtion = $request->orderCondtion ?? '';
        if($orderCondtion){
            $projects = Project::orderBy($orderCondtion)->paginate($numOfElementsToView);
        }
        else{
            $projects = Project::paginate($numOfElementsToView);
        }
        $numOfTrashedElements = Project::onlyTrashed()->get()->count();
        return view('admin.pages.projects.index' , compact('projects' , 'numOfTrashedElements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return view('admin.pages.projects.create' , compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->validate($this->rules , $this->messages);
        $formData['slug'] = Str::slug($formData['title']);
        $formData['img_path'] =  Storage::put('imgs/', $formData['img_path']);
        
        $newProject = new Project();
        
        $newProject -> fill($formData);
        $newProject->save();

        $successMessage = "
            <div class='my_alert-popup my_success'>
                <h1 class='fw-bold'>Creazione completata!</h1>
                <h5 class='my_alert-popup'>L'elemento \"$newProject->title\" è stato creato</h5>
            </div>";

        return redirect()->route('admin.pages.projects.index')->with("success" , "$successMessage");
    }

    /**
     * Display the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $previousProject = Project::where('id', '<', $project->id)->orderBy('id', 'DESC')->first();
        $nextProject = Project::where('id', '>', $project->id)->orderBy('id')->first();
        return view('admin.pages.projects.show',compact('project' , 'previousProject' , 'nextProject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.pages.projects.edit' , compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $newRules = $this->rules;
        $newRules['title'] = ['required','string' , 'between:2,255' , Rule::unique('projects')->ignore($project->id)];
        $newRules['slug'] = ['string' , 'between:2,255' , Rule::unique('projects')->ignore($project->id)];
        $newRules['img_path'] = ['required','image' , 'max:300' , Rule::unique('projects')->ignore($project->id)];

        $formData = $request->validate($newRules , $this->messages);
        $formData['slug'] = Str::slug($formData['title']);

        if ($request->hasFile('img_path')){

            if (!$project->isImageAUrl()){
                Storage::delete($project->img_path);
            }

            $formData['img_path'] =  Storage::put('imgs/', $formData['img_path']);
        }

        $project->update($formData);

        $successMessage = "
            <div class='my_alert-popup my_success'>
                <h1 class='fw-bold'>Congratulazioni!</h3>
                <h5 class='my_alert-message'>$project->title è stato modificato</h5>
            </div>";


        return redirect()->route('admin.pages.projects.index',compact('project'))->with('success',"$successMessage");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        
        $successMessage = "
        <div class='my_alert-popup my_success'>
            <h1 class='fw-bold'>Cestinazione completata!</h1>
            <h5 class='my_alert-message'>$project->title è stato spostato nel cestino</h5>
        </div>";
        
        return redirect()->route('admin.pages.projects.index')->with('success' , "$successMessage");
    }

    /**
     * Display a listing of the trashed resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $numOfElementsToView = 5;
        $orderCondtion = $request->orderCondtion ?? '';
        if($orderCondtion){
            $trashedProjects = Project::onlyTrashed()->orderBy($orderCondtion)->paginate($numOfElementsToView);
        }
        else{
            $trashedProjects = Project::onlyTrashed()->paginate($numOfElementsToView);
        }
        // $trashedProjects = Project::onlyTrashed()->paginate($numOfElementsToView);
        return view('admin.pages.projects.trashed' , compact('trashedProjects'));
    }

    /**
     * Restore the trashed resource.
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Project::where('id' , $id)->withTrashed()->restore();

        $successMessage = "
        <div class='my-alert-popup my_success'>
            <h1 class='fw-bold'>Ripristino concluso!</h1>
            <h5 class='my_alert-message'>L'elemento con id <code>$id</code> è stato ripristinato</h5>
        </div>";

        return redirect()->route('admin.pages.projects.index')->with('success' , "$successMessage");
    }

    /**
     * Restore all the trashed resources.
     * @return \Illuminate\Http\Response
     */
    public function restoreAll()
    {
        $numOfRestoredProjects = Project::onlyTrashed()->count();
        Project::onlyTrashed()->restore();

        $successMessage = "
        <div class='my-alert-popup my_success'>
            <h1 class='fw-bold'>Ripristino concluso!</h1>
            <h5 class='my_alert-message'><code>$numOfRestoredProjects</code> elementi sono stati ripristinati</h5>
        </div>";
        // $digit = new NumberFormatter("en" , NumberFormatter::SPELLOUT);
        // $convertedNumOfRestoredProjects = $digit->format($numOfRestoredProjects);
        return redirect()->route('admin.pages.projects.index')->with('success' , "$successMessage");
    }

    /**
     * Force delete resource.
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        Project::where('id' , $id)->withTrashed()->forceDelete();

        $successMessage = "
        <div class='my-alert-popup my_success'>
            <h1 class='fw-bold'>Eliminazione definitiva conclusa!</h1>
            <h5 class='my_alert-message'>L'elemento con id <code>$id</code> è stato cancellato definitivamente</h5>
        </div>";

        return redirect()->route('admin.pages.projects.trashed')->with('success' , "$successMessage");
    }

    /**
     * Force delete all the trashed resources.
     * @return \Illuminate\Http\Response
     */
    public function emptyTrash()
    {
        $numOfDeletedProjects = Project::onlyTrashed()->count();
        Project::onlyTrashed()->forceDelete();

        $successMessage = "
        <div class='my-alert-popup my_success'>
            <h1 class='fw-bold'>Eliminazione definitiva conclusa!</h1>
            <h5 class='my_alert-message'><code>$numOfDeletedProjects</code> elementi sono stati cancellati definitivamente</h5>
        </div>";

        return redirect()->route('admin.pages.projects.index')->with('success' , "$successMessage");
    }
}