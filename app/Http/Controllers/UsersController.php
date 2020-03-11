<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
    public function __construct() {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $page = $request->input('page');

        $users_paginate = User::paginate(4);

        if ($page) {
            $offset = $users_paginate->firstItem() - 1;

            $users_list = User::limit(4)->offset($offset)->get();
        } else {
            //выбираем пользователей из БД
            $users_list = User::limit(4)->offset(0)->get();
        }

        return view('users.users', ['users_list' => $users_list, 'users_paginate' => $users_paginate]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_name' => 'required|min:3|max:255',
            'user_email' => 'required|email',
            'user_password' => 'required|min:3|max:255'
        ]);

        //проверим, есть ли сейчас пользователь
        $user_exist = User::where('email', '=', $request->input('user_email'))->first();

        if (empty($user_exist)) {
            $user = new User();
            $user->name = $request->input('user_name');
            $user->email = $request->input('user_email');
            $user->password = bcrypt($request->input('user_password'));
            $user->save();

            return view('users.create_user');
        } else {
            return view('users.exist_user');
        }
    }

    public function add(Request $request)
    {
        return view('users.add_user');
    }

    public function delete($user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        //удаляем все связи пользователя и отделов
        DB::table('users_departments')->where('user_id', '=', $user_id)->delete();

        return view('users.delete_user');
    }

    public function edit($user_id)
    {
        $user_info = User::find($user_id);

        return view('users.edit_user', ['user_info' => $user_info]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_name' => 'required|min:3|max:255',
            'user_email' => 'required|email'
        ]);

        $user = User::find($request->input('user_id'));
        $user->name = $request->input('user_name');
        $user->email = $request->input('user_email');

        if ($request->input('user_password')) {
            $request->validate([
                'user_password' => 'min:3|max:255'
            ]);

            $user->password = $request->input('user_password');
        }

        $user->save();

        return view('users.update_user');
    }
}
