@extends('backend.layouts.backend_master')

@section('title','Tasks')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title d-inline">Tasks</h3>
                    {{-- <a href="{{ route('team-leader.tasks.create') }}" class="btn btn-success btn-sm
                    float-right">New Task</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Project</th>
                                <th>Status</th>
                                <th>Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $key=>$task)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->level }}</td>
                                <td>{{ $task->project->name }}</td>
                                <td>{{ $task->status }}</td>
                                <td>{{ date('F d Y',strtotime($task->start_date)) }}</td>
                                
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
