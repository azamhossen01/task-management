<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('team_id',Auth::user()->team_id)->get();
        return view('backend.pages.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::where('id',Auth::user()->team_id)->get();
        return view('backend.pages.projects.create',compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|min:5|unique:projects',
            'status' => 'required',
            'members' => 'required',
            'team_id' => 'required'
        ]);
        $request->merge(['created_by' => Auth::id()]);
        // return $request;
        $project = Project::create($request->all());
        if($project){
            return redirect()->route('team-leader.projects.index')->with('success','Project created successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $teams = Team::all();
        return view('backend.pages.projects.edit',compact('project','teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $request->validate([
            'name' => 'required|max:100|min:5|unique:projects,name,'.$project->id,
            'status' => 'required',
            'members' => 'required',
            'team_id' => 'required'
        ]);
        $request->merge(['updated_by' => Auth::id()]);
        $update = $project->update($request->all());
        if($update){
            return redirect()->route('team-leader.projects.index')->with('success','Project updated successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $delete = $project->delete();
        if($delete){
            return redirect()->route('team-leader.projects.index')->with('success','Project deleted successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }
}
