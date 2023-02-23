<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use NumberFormatter;

class ProjectController extends Controller
{
    protected $rules = [
        'title' => 'required|string|unique:projects|between:2,255',
        'description' => 'required|min:10',
    ];

    protected $messages = [
        'title.required' => 'Il titolo deve essere inserito obbligatoriamente',
        'description.min' => 'La descrizione non è abbastanza lunga(min=10 caratteri)',
        'title.between' => 'Il titolo deve avere un numero di caratteri compreso tra 2 e 255',
    ];
    /**
     * Display a listing of the resource.
     *
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

        $newProject = new Project();

        $newProject -> fill($formData);
        $newProject->save();

        return redirect()->route('admin.pages.projects.index')->with('message',"$newProject->title has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.pages.projects.show',compact('project'));
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

        $formData = $request->validate($newRules , $this->messages);
        $formData['slug'] = Str::slug($formData['title']);

        $project->update($formData);


        return redirect()->route('admin.pages.projects.index',compact('project'))->with('message',"$project->title with id $project->id has been modified");
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
        return redirect()->route('admin.pages.projects.index')->with('message' , "$project->title has been moved to the recycled bin");
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $numOfElementsToView = 5;
        $trashedProjects = Project::onlyTrashed()->paginate($numOfElementsToView);
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
        return redirect()->route('admin.pages.projects.index')->with('message' , "The element with id $id has been restored");
    }

    /**
     * Restore all the trashed resources.
     * @return \Illuminate\Http\Response
     */
    public function restoreAll()
    {
        $numOfRestoredProjects = Project::onlyTrashed()->count();
        Project::onlyTrashed()->restore();
        // $digit = new NumberFormatter("en" , NumberFormatter::SPELLOUT);
        // $convertedNumOfRestoredProjects = $digit->format($numOfRestoredProjects);
        return redirect()->route('admin.pages.projects.index')->with('message' , "$numOfRestoredProjects elements have been restored");
    }

    /**
     * Force delete resource.
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        Project::where('id' , $id)->withTrashed()->forceDelete();
        return redirect()->route('admin.pages.projects.trashed');
    }

    /**
     * Force delete all the trashed resources.
     * @return \Illuminate\Http\Response
     */
    public function emptyTrash()
    {
        $numOfDeletedProjects = Project::onlyTrashed()->count();
        Project::onlyTrashed()->forceDelete();
        return redirect()->route('admin.pages.projects.index')->with('message' , "$numOfDeletedProjects has been definitely deleted");
    }
}