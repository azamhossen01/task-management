<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeveloperController extends Controller
{
    public function tasks(){
        $tasks = Task::where('assign_to',Auth::id())->get();
        return view('backend.pages.developer.tasks',compact('tasks'));
    }

    public function kanban(){
        $tasks = Task::where('assign_to',Auth::id())->get();
        return view('backend.pages.developer.kanban',compact('tasks'));
    }

    public function getTaskData(Request $request){
        $tasks = Task::with('project','developer')->where('project_id',$request->id)->where('assign_to',Auth::id())->get();
        return response()->json($tasks);
    }

    public function developerProjects(){
        $projects = Project::whereHas('tasks',function($query){
            return $query->where('assign_to',Auth::id());
        })->get();
        
        return view('backend.pages.developer.projects',compact('projects'));
    }

    public function projectDetails($id){
        $project = Project::findOrFail($id);
        return view('backend.pages.developer.kanban',compact('project'));
    }

    public function changeTaskStatus(Request $request){
        $task = Task::findOrFail($request->task_id);
        $result = $task->update(['status' => $request->status]);
        if($result){
            return response()->json(['message' => 'Task moved to in-progress']);
        }else{
            return false;
        }
    }

    public function taskCreate(Request $request){
        $request->validate([
            'title' => 'required|max:1000|min:5',
            'image' => 'mimes:png,jpg|max:2048|sometimes',
            'level' => 'required',
            'status' => 'required',
            'project_id' => 'required'
        ]);
        if($request->hasFile('image')){
            $image_name = time().'.'.$request->image->extension();
            $request->file('image')->storeAs('tasks',$image_name,'public');
        }else{
            $image_name = null;
        }
        $task = Task::create([
            'title' => $request->title,
            'image' => $image_name,
            'level' => $request->level,
            'status' => $request->status,
            'project_id' => $request->project_id,
            'description' => $request->description,
            'assign_to' => Auth::id(),
            'created_by' => Auth::id()
        ]);
        if($task){
            return redirect()->back()->with('success','Task created successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }

    public function taskDelete(Request $request){
        $task = Task::findOrFail($request->task_id);
        if(!empty($task->image)){
            Storage::disk('public')->delete('tasks/'.$task->image);
        }
        $result = $task->delete();
        if($result){
            return redirect()->back()->with('success','Task deleted successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong. Please try again later');
        }
    }

    public function weather(){
        $curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://community-open-weather-map.p.rapidapi.com/weather?q=London%2Cuk&lat=0&lon=0&callback=test&id=2172797&lang=null&units=imperial&mode=xml",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
		"x-rapidapi-key: f7e7069a16msha9d7e2aff7820d6p128d86jsn0fec9cdb6a04"
        
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
    }
}
