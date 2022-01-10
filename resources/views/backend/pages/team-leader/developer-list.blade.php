@extends('backend.layouts.backend_master')

@section('title','Developers')

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title d-inline">Developers</h3>
            {{-- <a href="{{ route('team-leader.projects.create') }}" class="btn btn-success btn-sm float-right">New Project</a> --}}
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($developers as $key=>$developer)
                    <tr>
                      <td>{{ $key+1 }}</td>
                    <td>{{ $developer->name }}</td>
                    <td>{{ $developer->email }}</td>
                    <td>{{ $developer->created_at->diffForHumans() }}</td>
                    
                    </tr>
                @empty
                    <tr>
                        No projects available
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