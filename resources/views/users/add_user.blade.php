@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('messages.create_user') }}</div>
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

                    <form action="/users" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_name">{{__('messages.name')}}</label>
                            <input type="name" name="user_name" class="form-control" placeholder="{{__('messages.enter_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="user_email">{{__('messages.email')}}</label>
                            <input type="text" name="user_email" class="form-control" placeholder="{{__('messages.enter_email')}}">
                        </div>
                        <div class="form-group">
                            <label for="user_password">{{__('messages.password')}}</label>
                            <input type="password" name="user_password" class="form-control" placeholder="{{__('messages.enter_password')}}">
                        </div>
                        @csrf
                        <input type="hidden" name="create_user" value="1">
                        <button type="submit" class="btn btn-primary">{{__('messages.submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
