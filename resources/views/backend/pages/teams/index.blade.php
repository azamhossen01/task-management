@extends('backend.layouts.backend_master')

@section('title','Teams')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Teams</h3>
            <a href="{{ route('admin.teams.create') }}" class="btn btn-success btn-sm float-right">New Team</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Title</th>
                  <th>Members</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($teams as $key=>$team)
                    <tr>
                      <td>{{ $key+1 }}</td>
                    <td>{{ $team->title }}</td>
                    <td>{{ $team->members }}</td>
                    <td>{{ $team->created_at->diffForHumans() }}</td>
                    <td>
                        <form action="{{ route('admin.teams.destroy',$team->id) }}" class="d-inline" method="post">
                            @csrf 
                            @method('delete')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                        <a  href="{{ route('admin.teams.edit',$team->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>
                    </td>
                    </tr>
                @empty
                    <tr>
                        No team available
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