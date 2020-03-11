@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('messages.users')}} <a href="/users/create" class="btn btn-primary" style="float: right;">{{ __('messages.add') }}</a></div>

                <div class="card-body">
                        @if (session('add_user_name'))
                            <div class="alert alert-success">
                                Пользователь {{session('add_user_name')}} добавлен
                            </div>
                        @endif
                        
                        @if (session('delete_user_name'))
                            <div class="alert alert-success">
                                Пользователь {{session('delete_user_name')}} удален
                            </div>
                        @endif
                        
                        @if (session('edit_user_name'))
                            <div class="alert alert-success">
                                Пользователь {{session('edit_user_name')}} отредактирован
                            </div>
                        @endif
                    
                    <table class="table">
                        @foreach ($users_list as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="/users/{{$user->id}}/edit" class="btn btn-secondary" style="float: left; margin-right: 7px;">{{__('messages.edit')}}</a>
                                    
                                    <form action="/users/{{$user->id}}" method="post">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure?');">{{__('messages.delete')}}</button>
                                        
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{ $users_paginate->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
