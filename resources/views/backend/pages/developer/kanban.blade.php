@extends('backend.layouts.backend_master')

@section('title','Kanban Board')

@push('css')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/toastr/toastr.min.css">
    <style>
        .card-body::after, .card-footer::after, .card-header::after {
    display: block;
    clear: both;
    content: none !important;
}
    </style>
@endpush

@section('content')
<section class="content pb-3">
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-lg-3">
                <div class="card card-row card-default">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                            Project Details
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="card card-light card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Name : {{ $project->name }}</h5>
                            </div>
                            <div class="card-body">
                                <p>Status : {{ $project->status }}</p>
                                <p>Members : {{ $project->members }}</p>
                                <p>Start Date : {{ date('F d Y',strtotime($project->start_date)) }}</p>
                                <p>End Date : {{ date('F d Y',strtotime($project->end_date)) }}</p>
                                <p>Total Tasks : {{ $project->tasks->count() }}</p>
                                <p>My Tasks : {{ $project->developerTasks(Auth::id())->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-row card-primary">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">
                            To Do
                        </h3>
                        <span class="right btn badge badge-success" onclick="addNewTask()">New Task</span>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12 col-sm-6" id="to-do-list">
                            <!-- checkbox -->
                            {{-- @forelse ($project->developerTasks(Auth::id()) as $key=>$task)
                            <div class="form-group clearfix">
                                <div class="icheck-success d-inline" onclick="change_task_status({{ $task->id }},'in-progress')">
                                  <input type="checkbox"  id="task{{ $task->id }}">
                                  <label for="task{{ $task->id }}">
                                    {{ $task->title }}
                                  </label>
                                </div>
                              </div><hr>
                            @empty
                                
                            @endforelse --}}
                          </div>



                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-row card-default">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                            In Progress
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12" id="in_progress_task">

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-row card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            Done
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12" id="done_task">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{-- modal start here --}}
<div class="modal fade" id="task-modal">
    <div class="modal-dialog">
      <div class="modal-content bg-success">
        <div class="modal-header">
          <h4 class="modal-title">{{ $project->name }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('developer.tasks.create') }}" method="post" enctype="multipart/form-data">
                @csrf 
                <input type="hidden" name="project_id" value="{{ $project->id }}">
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
                  <button type="submit" class="btn btn-danger btn-block">Submit</button>
                </div>
              </form>
        </div>
        {{-- <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-outline-light">Save changes</button>
        </div> --}}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
{{-- modal end here --}}

    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('backend') }}/plugins/toastr/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            };
            getDeveloperTodoTask();
        });
       
        
        function getDeveloperTodoTask(){

            $.ajax({
                type : "post",
                data : { id : {{ $project->id }} },
                url : "{{ route('developer.developer_todo_task') }}",
                success : function(data){
                    if(data.length > 0){
                        let todo = ``;
                        let in_progress = ``;
                        let done_task = ``;
                        let todo_counter = in_progress_counter = done_task_counter = 1;
                        let auth_id =  {{ Auth::id() }}
                        
                        $(data).each((index,task)=>{
                            
                            if(task.status == 'to-do'){
                                todo += `
                                <div class="form-group clearfix mb-1"  onclick="change_task_status(${task.id},'in-progress')">
                                    <div class="icheck-success d-inline">
                                    <input type="checkbox"  id="task${task.id}">
                                    <label for="task${task.id}" data-toggle="tooltip" title="">
                                       <span  data-original-title="Default tooltip">${todo_counter} .</span> ${task.title}
                                    </label>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" onclick=" deleteTask(${task.id})" class="text-danger "><code>${auth_id == task.created_by ? 'remove' : ''}</code></a>
                                <hr>
                                `;
                                todo_counter++;
                            }else if(task.status === 'in-progress'){
                                in_progress += `
                                <div class="form-group clearfix mb-1" onclick="change_task_status(${task.id},'done')">
                                    <div class="icheck-success d-inline">
                                    <input type="checkbox"  id="task${task.id}">
                                    <label for="task${task.id}">
                                       <span>${in_progress_counter} .</span> ${task.title}
                                    </label>
                                    </div>
                                </div>
                                    <a href="javascript:void(0)" onclick="change_task_status(${task.id},'to-do')" class="text-danger"><code>Cancel</code></a>
                                    <a href="javascript:void(0)" onclick="deleteTask(${task.id})" class="text-danger float-right"><code>${auth_id == task.created_by ? 'remove' : ''}</code></a>
                                    
                                    <hr>
                                `;
                                in_progress_counter++;
                            }else if(task.status === 'done'){
                                done_task += `
                                <div class="form-group clearfix mb-0">
                                    <div class="">
                                    
                                    <label for="task${task.id}">
                                       <span>${done_task_counter} .</span> ${task.title}
                                    </label>
                                    </div>
                                </div>
                                    <a href="javascript:void(0)" onclick="change_task_status(${task.id},'in-progress')" class="text-danger"><code>Cancel</code></a>
                                    <a href="javascript:void(0)" onclick="deleteTask(${task.id})" class="text-danger float-right"><code>${auth_id == task.created_by ? 'remove' : ''}</code></a>
                                    <hr>
                                `;
                                done_task_counter++;
                            }
                            
                        });
                        $('#to-do-list').html(todo);
                        $('#in_progress_task').html(in_progress);
                        $('#done_task').html(done_task);
                    }
                }
            });
        }

        function clearTasks(){

        }

        function deleteTask(task_id){
            if(task_id && confirm('Are you sure?')){
                $.ajax({
                    type : 'POST',
                    data : {task_id},
                    url : "{{ route('developer.task.delete') }}",
                    success : function(data){
                        toastr.success('Task deleted successfully')
                        getDeveloperTodoTask();
                    }
                });
            }
        }

        function change_task_status(task_id,status){
            // if($('#task'+task_id).attr('checked',true)){
                $.ajax({
                    type : 'POST',
                    data : {task_id:task_id,status : status},
                    url : "{{ route('developer.change_task_status') }}",
                    success : function(data){
                        getDeveloperTodoTask();
                    }
                });
            // }

        }

        function addNewTask(){
            $('#task-modal').modal('show');
        }
    </script>

@endpush
