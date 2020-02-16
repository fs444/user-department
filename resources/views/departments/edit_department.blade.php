@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('messages.edit_department')}}</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/departments/update" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="department_name">{{__('messages.name')}}</label>
                          <input type="name" name="department_name" value="{{$department_info->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="deparment_descr">{{__('messages.description')}}</label>
                          <input type="text" name="deparment_descr" value="{{$department_info->description}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="deparment_logo" id="department_file">
                                <label class="custom-file-label" for="department_file">{{__('messages.choose_file')}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>{{__('messages.users')}}</h3>
                            @foreach ($user_list as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="user_id[]" value="{{$user->id}}" id="user_{{$user->id}}"
                                      @foreach ($checked_user_list as $checked_user)
                                          @if ($user->id == $checked_user->id)
                                              checked
                                          @endif
                                      @endforeach
                                           >
                                    <label class="form-check-label" for="user_{{$user->id}}">
                                        {{$user->name}} (<a href="mailto:{{$user->email}}">{{$user->email}}</a>)
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @csrf
                        <input type="hidden" name="department_id" value="{{$department_info->id}}">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{__('messages.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
