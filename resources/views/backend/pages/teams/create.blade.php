@extends('backend.layouts.backend_master')

@section('title','Teams')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Roles</h3>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-success btn-sm float-right">Back</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('admin.teams.store') }}" method="post">
              @csrf 
              <div class="form-group">
                <label for="title">Team Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Team Title" value="{{ old('title') }}">
                @error('title')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="members">Members</label>
                <input type="number" name="members" class="form-control" id="members" placeholder="Team Members" value="{{ old('members') }}">
                @error('members')
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