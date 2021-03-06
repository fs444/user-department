@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('messages.departments') }} <a href="/departments/create" class="btn btn-primary pull-right" style="float: right;">{{ __('messages.add') }}</a>
                </div>
                <div class="card-body">
                    @if (session('add_dep_name'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Отдел {{session('add_dep_name')}} добавлен
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('delete_dep_name'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Отдел {{session('delete_dep_name')}} удален
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('not_delete_dep_name'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Ошибка. В отделе есть пользователи.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('edit_dep_name'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Отдел {{session('edit_dep_name')}} отредактирован
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <table class="table">
                        @foreach ($department_list as $department)
                            <tr>
                                <td><img src="{{$department->showDepartmentImg(asset('storage'), $department->logo)}}" width="200" height="133" class="img-thumbnail"></td>
                                <td>
                                    <div class="font-weight-bold">{{$department->name}}</div>
                                    <div>{{$department->description}}</div>
                                </td>
                                <td>
                                    <p class="font-weight-bold">{{ __('messages.users') }}</p>
                                    {{ $department::departmentUsers($department->id) }}
                                </td>
                                <td>
                                    <a href="/departments/{{$department->id}}/edit" class="btn btn-secondary" style="float: left; margin-right: 7px;">{{ __('messages.edit') }}</a>
                                    
                                    <form action="/departments/{{$department->id}}" method="post">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure?');">{{ __('messages.delete') }}</button>

                                        @csrf
                                    </form>
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
