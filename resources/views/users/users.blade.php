@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('messages.users')}} <a href="/users/add" class="btn btn-primary" style="float: right;">{{ __('messages.add') }}</a></div>

                <div class="card-body">
                    <table class="table">
                        @foreach ($users_list as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="/users/edit/{{$user->id}}" class="btn btn-secondary">{{__('messages.edit')}}</a>
                                    <a href="/users/delete/{{$user->id}}" class="btn btn-danger">{{__('messages.delete')}}</a>
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
