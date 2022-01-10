@extends('backend.layouts.backend_master')

@section('title','Projects')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title d-inline">Project</h3>
                    {{-- <a href="{{ route('team-leader.tasks.create') }}" class="btn btn-success btn-sm
                    float-right">New Task</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Member</th>
                                <th>Start Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $key=>$project)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->status }}</td>
                                <td>{{ $project->members }}</td>
                                <td>{{ date('F d Y',strtotime($project->start_date)) }}</td>
                                <td>
                                    <a href="{{ route('developer.project.details',$project->id) }}" class="btn btn-success">Tasks ({{ $project->developerTasks(Auth::id())->count() }})</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                No task available
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
