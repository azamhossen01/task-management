<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeaderController extends Controller
{
    public function developerList(){
        $developers = User::where('role_id',3)->where('team_id',Auth::user()->team_id)->get();
        return view('backend.pages.team-leader.developer-list',compact('developers'));
    }
}
