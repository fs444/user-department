@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('messages.departments') }} <a href="/departments/add" class="btn btn-primary pull-right" style="float: right;">{{ __('messages.add') }}</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach ($department_list as $department)
                            <tr>
                                <td><img src="{{ asset('storage') }}/{{$department->logo}}" width="200" height="133" class="img-thumbnail"></td>
                                <td>
                                    <div class="font-weight-bold">{{$department->name}}</div>
                                    <div>{{$department->description}}</div>
                                </td>
                                <td>
                                    <p class="font-weight-bold">{{ __('messages.users') }}</p>
                                    {{ $department::departmentUsers($department->id) }}
                                </td>
                                <td>
                                    <a href="/departments/edit/{{$department->id}}" class="btn btn-secondary">{{ __('messages.edit') }}</a>
                                    <a href="/departments/delete/{{$department->id}}" class="btn btn-danger">{{ __('messages.delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{ $department_paginate->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
