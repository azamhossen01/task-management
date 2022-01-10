<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::whereHas('project',function($query){
            $query->where('team_id',Auth::user()->team_id);
        })->get();
        return view('backend.pages.tasks.index',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::where('team_id',Auth::user()->team_id)->get();
        $developers = User::where('role_id',3)->where('team_id',Auth::user()->team_id)->get();
        return view('backend.pages.tasks.create',compact('projects','developers'));
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
            'title' => 'required|max:1000|min:5',
            'image' => 'mimes:png,jpg|max:2048|sometimes',
            'level' => 'required',
            'status' => 'required',
            'assign_to' => 'required',
            'project_id' => 'required'
        ]);
        if($request->hasFile('image')){
            $image_name = time().'.'.$request->image->extension();
            $request->file('image')->storeAs('tasks',$image_name,'public');
        }else{
            $image_name = "";
        }
        $task = Task::create([
            'title' => $request->title,
            'image' => $image_name,
            'level' => $request->level,
            'status' => $request->status,
            'assign_to' => $request->assign_to,
            'project_id' => $request->project_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => Auth::id()
        ]);
        // return $request->all();
        // $task = Task::create($request->all());
        if($task){
            return redirect()->route('team-leader.tasks.index')->with('success','Task created successfully');
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
        $task = Task::findOrFail($id);
        $projects = Project::where('team_id',Auth::user()->team_id)->get();
        $developers = User::where('role_id',3)->where('team_id',Auth::user()->team_id)->get();
        return view('backend.pages.tasks.edit',compact('task','projects','developers'));
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
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => 'required|max:1000|min:5',
            'image' => 'mimes:png,jpg|max:2048|sometimes',
            'level' => 'required',
            'status' => 'required',
            'assign_to' => 'required',
            'project_id' => 'required'
        ]);
        if($request->hasFile('image')){
            if(!empty($task->image)){
                Storage::disk('public')->delete('tasks/'.$task->image);
            }
            $image_name = time().'.'.$request->image->extension();
            $request->file('image')->storeAs('tasks',$image_name,'public');
        }else{
            $image_name = $task->image;
        }
        $update = $task->update([
            'title' => $request->title,
            'image' => $image_name,
            'level' => $request->level,
            'status' => $request->status,
            'assign_to' => $request->assign_to,
            'project_id' => $request->project_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_by' => Auth::id()
        ]);
        if($update){
            return redirect()->route('team-leader.tasks.index')->with('success','Task updated successfully');
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
        //
    }
}
