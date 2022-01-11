@extends('backend.layouts.backend_master')

@section('title','Profile')

@push('css')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/toastr/toastr.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="{{ asset('storage/profiles/'.$user->photo) }}"
                   alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ $user->name }}
            <small><i class="text-center">{{ $user->email }}</i></small></h3>

            <p class="text-muted text-center">{{ Str::title($user->role->name) }} 
            @if ($user->role_id != 1)
                ({{ Str::title($user->team->title) }})
            @endif
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Projects</b> <a class="float-right">{{ $projects }}</a>
              </li>
              <li class="list-group-item">
                <b>Developers</b> <a class="float-right">{{ $developers }}</a>
              </li>
              <li class="list-group-item">
                <b>Tasks</b> <a class="float-right">{{ $tasks }}</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        {{-- <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">About Me</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-book mr-1"></i> Education</strong>

            <p class="text-muted">
              B.S. in Computer Science from the University of Tennessee at Knoxville
            </p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

            <p class="text-muted">Malibu, California</p>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

            <p class="text-muted">
              <span class="tag tag-danger">UI Design</span>
              <span class="tag tag-success">Coding</span>
              <span class="tag tag-info">Javascript</span>
              <span class="tag tag-warning">PHP</span>
              <span class="tag tag-primary">Node.js</span>
            </p>

            <hr>

            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
          </div>
          <!-- /.card-body -->
        </div> --}}
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
              <h2>Update Profile</h2>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              
                <form action="{{ route('profile.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ old('name',$user->name) }}">
                      @error('name')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email',$user->email) }}">
                      @error('email')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="{{ old('password') }}" onchange="checkOldPassword(this.value)">
                      @error('password')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="password_confirm">Confirm Password</label>
                      <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Confirm Password" disabled value="{{ old('password') }}">
                      @error('password_confirm')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="gender">Gender : </label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" {{ $user->gender == 'male' ? 'checked' : '' }} name="gender" id="male" value="male">
                        <label class="form-check-label" for="male">Male</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" {{ $user->gender == 'female' ? 'checked' : '' }}  name="gender" id="female" value="female">
                        <label class="form-check-label" for="female">Female</label>
                      </div>
                      @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for=""></label>
                      <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </div>
                  </form>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
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
        });
    
         
        function checkOldPassword(password){
            if(password){
                $.ajax({
                    method : 'post',
                    data : {password},
                    url : "{{ route('check_old_password') }}",
                    success : function(data){
                        if(data){
                            $('#password_confirm').attr('disabled',false);
                            toastr.success('Password matched.')
                        }else{
                            $('#password').val("");
                            toastr.error('Please enter old password.')
                        }
                    }
                });
            }
        }
    </script>
@endpush