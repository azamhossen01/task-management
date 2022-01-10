<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id','!=',1)->get();
        return view('backend.pages.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        $roles = Role::where('id','!=',1)->get();
        return view('backend.pages.users.create',compact('teams','roles'));
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
            'name' => 'required|max:100|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:12|min:6',
            'gender' => 'required',
            'team_id' => 'required',
            'role_id' => 'required'
        ]);
        $request->merge(['password' => bcrypt($request->password),'created_by' => Auth::id()]);
        $user = User::create($request->all());
        if($user){
            return redirect()->route('admin.users.index')->with('success','User created successfully');
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
        $teams = Team::all();
        $roles = Role::where('id','!=',1)->get();
        $user = User::findOrFail($id);
        return view('backend.pages.users.edit',compact('teams','roles','user'));
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
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|min:5|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender' => 'required',
            'team_id' => 'required',
            'role_id' => 'required' 
        ]);
        if($request->password){
            $request->merge(['password' => bcrypt($request->password)]);
        }else{
            $request->merge(['password' => $user->password]);
        }
        $request->merge(['updated_by' => Auth::id()]);
        $update = $user->update($request->all());
        if($update){
            if($update){
                return redirect()->route('admin.users.index')->with('success','User updated successfully');
            }else{
                return redirect()->back()->with('error','Something went wrong. Please try again later');
            }
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
