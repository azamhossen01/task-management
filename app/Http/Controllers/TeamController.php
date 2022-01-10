<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return view('backend.pages.teams.index',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.teams.create');
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
            'title' => 'required|max:50|unique:teams',
            'members' => 'required'
        ]);
        $request->merge(['created_by' => Auth::id()]);
        $team = Team::create($request->all());
        if($team){
            return redirect()->route('admin.teams.index')->with('success','Team created successfully');
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
        $team = Team::findOrFail($id);
        return view('backend.pages.teams.edit',compact('team'));
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
        $team = Team::findOrFail($id);
        $request->validate([
            'title' => 'required|max:50|unique:teams,title,'.$team->id,
            'members' => 'required'
        ]);
        $request->merge(['updated_by' => Auth::id()]);
        $team->update($request->all());
        if($team){
            return redirect()->route('admin.teams.index')->with('success','Team updated successfully');
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
        $team = Team::findOrFail($id);
        $team->delete();
        if($team){
            return redirect()->route('admin.teams.index')->with('success','Team deleted successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }
}
