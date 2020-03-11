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
                                    <a href="/departments/{{$department->id}}/edit" class="btn btn-secondary mr20" style="float: left; margin-right: 20px;">{{ __('messages.edit') }}</a>
                                    
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
