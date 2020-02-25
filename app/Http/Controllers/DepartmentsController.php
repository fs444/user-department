<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $page = $request->input('page');

        $department_paginate = Department::paginate(4);

        if ($page) {
            $offset = $department_paginate->firstItem() - 1;

            $department_list = Department::limit(4)->offset($offset)->get();
        } else {
            //выбираем департменты из БД
            $department_list = Department::limit(4)->offset(0)->get();
        }

        return view('departments.departments', [
            'department_list' => $department_list,
            'department_paginate' => $department_paginate
            ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'department_name' => 'required|min:3|max:255'
        ]);

        $department = new Department();
        $department->name = $request->input('department_name');
        $department->description = $request->input('deparment_descr');
        $department->logo = 'images/default.jpg';
        $department->save();

        //получим id только что добавленного отдела
        $last_id = DB::getPdo()->lastInsertId();

        if ($request->file('deparment_logo')) {
            $file_extension = "." . $request->file('deparment_logo')->getClientOriginalExtension();

            $file_path = $request->file('deparment_logo')->storeAs('images', $last_id . $file_extension);

            $department = Department::find($last_id);
            $department->logo = $file_path;
            $department->save();
        }

        if ($request->input('user_id')) {
            //очистим записи о всех юзерах этого департмента
            $department->addDepartmentUsers($request->input('user_id'), $last_id);
        }

        return view('departments.create_department');
    }

    public function add()
    {
        //отображаем список пользователей
        $user_list = User::all();

        return view('departments.add_department', ['user_list' => $user_list]);
    }

    public function delete($department_id)
    {
        //проверим, есть ли у департмента пользователи
        $user_in_department = DB::table('users_departments')->where('department_id', '=', $department_id)->count();

        if ($user_in_department == 0) {
            $department = Department::find($department_id);

            $department->deleteDepartmentImg($department->logo);

            $department->delete();

            return view('departments.delete_department');
        } else {
            return view('departments.not_delete_department');
        }
    }

    public function edit($department_id)
    {
        $department_info = Department::find($department_id);

        //отображаем список пользователей
        $user_list = User::all();

        //определим пользователей, которые отмечены для департмента
        $checked_user_list = Department::find($department_id)->users()->get();

        return view('departments.edit_department', [
            'department_info' => $department_info,
            'user_list' => $user_list,
            'checked_user_list' => $checked_user_list
        ]);
    }

    public function update(Request $request)
    {
        $department = Department::find($request->input('department_id'));
        $department->name = $request->input('department_name');
        $department->description = $request->input('deparment_descr');

        if ($request->file('deparment_logo')) {
            $file_extension = "." . $request->file('deparment_logo')->getClientOriginalExtension();

            $file_path = $request->file('deparment_logo')->storeAs('images', $request->input('department_id') . $file_extension);

            $department->logo = $file_path;

            Department::where('id', '=', $request->input('department_id'))->update(['logo' => $file_path]);
        }

        $department->save();

        $department->addDepartmentUsers($request->input('user_id'), $request->input('department_id'));

        return view('departments.update_department');
    }
}
