@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>{{__('messages.success_create_user')}}</p>

                    <p><a href="/users">{{__('messages.go_to_user_list')}}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
