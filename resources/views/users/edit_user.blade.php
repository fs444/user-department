@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('messages.edit_user')}}</div>
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

                    <form action="/users/update" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="user_name">{{__('messages.name')}}</label>
                          <input type="name" name="user_name" value="{{$user_info->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="user_email">{{__('messages.email')}}</label>
                          <input type="text" name="user_email" value="{{$user_info->email}}" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="user_password">{{__('messages.password')}}</label>
                          <input type="password" name="user_password" value="" class="form-control">
                        </div>
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user_info->id}}">
                        <button type="submit" class="btn btn-primary">{{__('messages.submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
