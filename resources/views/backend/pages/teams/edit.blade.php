@extends('backend.layouts.backend_master')

@section('title','Edit Team')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Edit Team</h3>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-success btn-sm float-right">Back</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('admin.teams.update',$team->id) }}" method="post">
              @csrf 
              @method('put')
              <div class="form-group">
                <label for="title">Team Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Team Title" value="{{ old('title',$team->title) }}">
                @error('title')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="members">Members</label>
                <input type="number" name="members" class="form-control" id="members" placeholder="Team Members" value="{{ old('members',$team->members) }}">
                @error('members')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for=""></label>
                <button type="submit" class="btn btn-warning btn-block">Submit</button>
              </div>
            </form>
          </div>
         
        </div>
      </div>
    </div>
    
  </div>

@endsection