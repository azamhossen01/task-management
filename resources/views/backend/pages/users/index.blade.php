@extends('backend.layouts.backend_master')

@section('title','User')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Users</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm float-right">New User</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Team</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $key=>$user)
                    <tr>
                      <td>{{ $key+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ $user->team->title }}</td>
                    <td>{{ $user->created_at->diffForHumans() }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy',$user->id) }}" class="d-inline" method="post">
                            @csrf 
                            @method('delete')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                        <a  href="{{ route('admin.users.edit',$user->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>
                    </td>
                    </tr>
                @empty
                    <tr>
                        No user available
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          {{-- <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
          </div> --}}
        </div>
      </div>
    </div>
    
  </div>

@endsection