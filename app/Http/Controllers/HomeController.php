<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.pages.dashboard');
    }

    public function profile($id){
        
        if(Auth::id() != $id){
            return redirect()->back();
        }
        $user = User::findOrFail($id);
        $projects = 0;
        $developers = 0;
        $tasks = 0;
            if($user->role_id != 1){
                $projects = $user->team->projects->count();
            $developers = $user->team->users->count();
            if($user->role_id == 2){
                $tasks = 0;
                foreach($user->team->projects as $project){
                    $tasks+=$project->tasks->count();
                }
            }elseif($user->role_id == 3){
                $tasks = Task::where('assign_to',$user->id)->get()->count();
            }
        }
        
        return view('backend.pages.profile',compact('user','projects','developers','tasks'));
    }

    public function updateProfile(Request $request,$id){
        if($id != Auth::id()){
            return redirect()->back();
        }
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'photo' => 'mimes:png,jpg|max:2048|sometimes'
        ]);
        if($request->hasFile('photo')){
            if(!empty($user->photo)){
                Storage::disk('public')->delete('profiles/'.$user->photo);
            }
            $image_name = time().'.'.$request->photo->extension();
            $request->file('photo')->storeAs('profiles',$image_name,'public');
        }else{
            $image_name = $user->photo;
        }
        if($request->password){
            $request->validate([
            'password' => 'required|min:6|max:12',
            'password_confirm' => 'required|same:password',
            ]);
            $password = bcrypt($request->password);
        }else{
            $password = $user->password;
        }
        // return $image_name;
        $update = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'password' => $password,
            'photo' => $image_name
        ]);
        if($update){
            return redirect()->back()->with('success','Profile updated successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }

    public function checkOldPassword(Request $request){
        $user = Auth::user();
        if(Hash::check($request->password,$user->password)){
            return true;
        }else{
            return false;
        }
    }
}
