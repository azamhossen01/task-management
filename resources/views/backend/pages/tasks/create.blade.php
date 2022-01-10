@extends('backend.layouts.backend_master')

@section('title','Tasks')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Tasks</h3>
            <a href="{{ route('team-leader.tasks.index') }}" class="btn btn-success btn-sm float-right">Back</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('team-leader.tasks.store') }}" method="post" enctype="multipart/form-data">
              @csrf 
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Task Title" value="{{ old('title') }}">
                @error('title')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" placeholder="Write Description" id="description" class="form-control" cols="30" rows="3" >{{ old('description') }}</textarea>
                @error('description')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image">
                @error('image')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="level">Level</label>
                <select name="level" id="level" class="form-control">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('level')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="to-do">To Do</option>
                    <option value="in-progress">In Progress</option>
                    <option value="done">Done</option>
                </select>
                @error('status')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="assign_to">Assign To</label>
                <select name="assign_to" id="assign_to" class="form-control">
                  @forelse ($developers as $developer)
                    <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                  @empty
                    
                  @endforelse
                </select>
                @error('assign_to')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="project_id">Project</label>
                <select name="project_id" id="project_id" class="form-control">
                  @forelse ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                  @empty
                    
                  @endforelse
                </select>
                @error('project_id')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Team start_date" value="{{ old('start_date') }}">
                @error('start_date')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" id="end_date" placeholder="Team end_date" value="{{ old('end_date') }}">
                @error('end_date')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for=""></label>
                <button type="submit" class="btn btn-success btn-block">Submit</button>
              </div>
            </form>
          </div>
         
        </div>
      </div>
    </div>
    
  </div>

@endsection