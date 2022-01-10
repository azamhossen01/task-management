@extends('backend.layouts.backend_master')

@section('title','Users')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Users</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-sm float-right">Back</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="post">
              @csrf 
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Team name" value="{{ old('name') }}">
                @error('name')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Team email" value="{{ old('email') }}">
                @error('email')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Team password" value="{{ old('password') }}">
                @error('password')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="gender">Gender : </label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" checked name="gender" id="male" value="male">
                  <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                  <label class="form-check-label" for="female">Female</label>
                </div>
                @error('gender')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="team_id">Team</label>
                <select name="team_id" id="team_id" class="form-control">
                  @forelse ($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->title }}</option>
                  @empty
                    
                  @endforelse
                </select>
                @error('team_id')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" id="role_id" class="form-control">
                  @forelse ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @empty
                    
                  @endforelse
                </select>
                @error('role_id')
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