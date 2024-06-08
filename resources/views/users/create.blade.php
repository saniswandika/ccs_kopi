@extends('layouts.app')


@section('content')
    
    <div class="container mt-4">
        <div class="card ">
            <div class="p-4 rounded ">
                <h1>Tambah Akun</h1>
              
        
                <div class="container mt-4">
                    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ old('name') }}" 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                placeholder="Name" required>
        
                            @if ($errors->has('name'))
                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input value="{{ old('email') }}"
                                type="email" 
                                class="form-control" 
                                name="email" 
                                placeholder="Email address" required>
                            @if ($errors->has('email'))
                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input value="{{ old('username') }}"
                                type="text" 
                                class="form-control" 
                                name="username" 
                                placeholder="Username" required>
                            @if ($errors->has('username'))
                                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Password:</strong>
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Confirm Password:</strong>
                                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Role:</strong>
                                <select class="form-control" name="roles" id="exampleFormControlSelect1">
                                 <option value="">
                                    {{-- @if(!empty($user->getRoleNames()))
                                      @foreach($user->getRoleNames() as $v)
                                          <label class="badge badge-success">{{ $v }}</label>
                                      @endforeach
                                    @endif --}}
                                  </option>
                                  @foreach ($roles as $role )
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                  @endforeach
                              </select> 
                                
                                {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','option')) !!} --}}
                            </div>
                        </div>
        
                        <button type="submit" class="btn btn-primary">Save user</button>
                        <a href="{{ route('page', ['page' => 'user-management']) }}" class="btn btn-default">Back</a>
                     {!! Form::close() !!}

                </div>
            </div>
        </div>
        
    </div>


@endsection