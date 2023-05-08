@extends('mylayouts.layout_panel')
<?php
   $modenya = $mode == 'add' ? 'tambah' : 'ubah';
   $titlePage = $modenya;
   ?>
@section('title', ucwords($titlePage.' pengguna aplikasi'))
@push('css')
@endpush
@section('content')
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 font-weight-bolder">{{ucwords($titlePage)}}
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{url('main/pengguna')}}">Pengguna</a></li>
               <li class="breadcrumb-item active">{{ucwords($titlePage)}}</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row g-1">
         <div class="col-lg-6 col-12">
            <div class="d-flex justify-content-start">
               <p class="mb-3">lengkapi data pengguna aplikasi dan pilih role yang dibutuhkan</p>
            </div>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="row g-3">
               <div class="col-lg-12 mb-3">
                  <form class="form" id="form"
                     method="post"
                     enctype="multipart/form-data"
                     action="{{$action}}" autocomplete="off">
                     {{csrf_field()}}
                     @if($mode=='edit')
                     {{ method_field('PUT') }}
                     @endif
                     <div class="row">
                        <div class="col-lg-12">
                           @include('mycomponents.alert')
                        </div>
                        <div class="col-lg-8">
                           <div class="card">
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="user-avatar-section mb-3">
                                          <div class=" d-flex align-items-center flex-column">
                                             <a class="image-popup-no-margins"
                                                href="{{getImageOri($avatar)}}">
                                             <img
                                                class="img-fluid rounded my-4 img-preview_avatar"
                                                src="{{getImageThumb($avatar)}}" height="110"
                                                width="110"
                                                alt="User avatar">
                                             </a>
                                          </div>
                                       </div>
                                       <div class="row mb-3">
                                          <label class="col-sm-3 col-form-label">Nama
                                          Lengkap</label>
                                          <div class="col-sm-9">
                                             <input
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="name" type="text"
                                                value="{{ $name }}"
                                                autofocus/>
                                             @error('name')
                                             <div class="invalid-feedback">
                                                {{ $message }}
                                             </div>
                                             @enderror
                                          </div>
                                       </div>
                                       <div class="row mb-3">
                                          <label for="inputPassword3"
                                             class="col-sm-3 col-form-label">Email</label>
                                          <div class="col-sm-9">
                                              <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                              </div>
                                                  <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                     name="email"
                                                     value="{{ $email }}"/>
                                                  @error('email')
                                                  <div class="invalid-feedback">
                                                     {{ $message }}
                                                  </div>
                                                  @enderror
                                              </div>
                                          </div>
                                       </div>
                                       <div class="row mb-3">
                                          <label for="_dm-inputAddress3"
                                             class="col-sm-3 form-label">Avatar</label>
                                          <div class="col-sm-9">
                                              <div class="custom-file">
                                                  <input id="avatar"
                                                         class="custom-file-input @error('avatar') is-invalid @enderror"
                                                         type="file" name="avatar"
                                                         accept="image/*"
                                                         onchange="previewImg('avatar')">
                                                  <label class="custom-file-label" for="avatar">Choose
                                                      file</label>
                                              </div>
                                              @error('avatar')
                                              <div class="invalid-feedback" style="color: red">
                                                  {{ $message }}
                                              </div>
                                              @enderror
                                             @if($mode=='edit')
                                             @if($avatar)
                                              @component('mycomponents.checkboxValue')
                                                  @slot('variabel')
                                                      avatar
                                                  @endslot
                                                  @slot('value')
                                                      {{$avatar}}
                                                  @endslot
                                                  @slot('teks')
                                                      hapus avatar
                                                  @endslot
                                              @endcomponent
                                             @endif
                                             @endif
                                             @error('avatar')
                                             <p style="color: red">{{ $message }}</p>
                                             @enderror
                                          </div>
                                       </div>
                                       <div class="row mb-3">
                                           <label for="inputPassword3" class="col-sm-3 col-form-label">Roles</label>
                                           <div class="col-sm-9">
                                          @foreach($roles as $x => $value)


                                                <div class="custom-control custom-radio">
                                               <input class="custom-control-input" name="roles" type="radio" value="{{$x}}" id="roles_{{$x}}" @if(in_array($x, $userRole, true)) checked @endif>
                                               <label for="roles_{{$x}}" class="custom-control-label">{{$x}}</label>
                                               </div>


                                          @endforeach
                                          @error('roles')
                                          <p style="color: red">
                                             {{ $message }}
                                          </p>
                                          @enderror
                                           </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--end::Card-->
                        </div>
                        <div class="col-lg-4">
                           <div class="card">
                              <h5 class="card-header text-center">Akun Pengguna</h5>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="mb-3">
                                          <label class="form-label" for="status">Status
                                          Akun</label>
                                          <select
                                             class="form-control select2bs5  @error('status') is-invalid @enderror"
                                             name="status" id="status">
                                          <option
                                          value=1 {{$status == 1 ? 'selected' : ''}}>
                                          Aktif
                                          </option>
                                          <option
                                          value=0 {{$status == 0 ? 'selected' : ''}}>
                                          Non
                                          Aktif
                                          </option>
                                          </select>
                                          @error('status')
                                          <div class="invalid-feedback">
                                             {{ $message }}
                                          </div>
                                          @enderror
                                       </div>
                                       <div class="mb-3">
                                          <label class="form-label" for="username">Username</label>
                                          <input
                                             class="form-control @error('username') is-invalid @enderror"
                                             name="username" id="username"
                                             type="text"
                                             value="{{ $username }}"/>
                                          @error('username')
                                          <div class="invalid-feedback">
                                             {{ $message }}
                                          </div>
                                          @enderror
                                       </div>
                                       <div class="mb-3">
                                          <label class="form-label" for="password">Password</label>
                                           <div class="input-group mb-3">
                                               <input type="password" id="password"
                                                      class="form-control @error('password') is-invalid @enderror"
                                                      name="password"/>
                                               <div class="input-group-prepend"
                                                    onclick="hintPass('password')">
                                                   <span class="input-group-text"
                                                         id="icon_password"><i
                                                           class="fas fa-eye-slash"></i></span>
                                               </div>
                                               @error('password')
                                               <div class="invalid-feedback">
                                                   {{ $message }}
                                               </div>
                                               @enderror
                                           </div>
                                       </div>
                                        <div class="mb-3">
                                           <label class="form-label" for="password_confirmation">Konfirmasi
                                           Password</label>
                                            <div class="input-group mb-3">
                                                <input type="password" id="password_confirmation"
                                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                                       name="password_confirmation"/>
                                                <div class="input-group-prepend"
                                                     onclick="hintPass('password_confirmation')">
                                                    <span class="input-group-text"
                                                          id="icon_password_confirmation"><i
                                                            class="fas fa-eye-slash"></i></span>
                                                </div>
                                                @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                 </div>
                              </div>
                              <div class="card-footer">
                                 <div class="d-flex justify-content-end">
                                    @if($mode=='add')
                                    <button type="reset" class="btn btn-secondary"
                                       style="margin-right: 20px">
                                    Reset Form
                                    </button>
                                    @endif
                                    @component('mycomponents.btnsubmit')
                                    @slot('variabel')
                                    @if($mode=='add') Submit @else Update @endif
                                    @endslot
                                    @endcomponent
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        changeTextFile('avatar');
    });
</script>
@endpush
