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

        $add_department = Department::insertGetId([
            'name' => $request->input('department_name'),
            'description' => $request->input('deparment_descr'),
            'logo' => 'images/default.jpg'
        ]);

        if ($request->file('deparment_logo')) {
            $file_extension = "." . $request->file('deparment_logo')->getClientOriginalExtension();

            $file_path = $request->file('deparment_logo')->storeAs('images', $request->input('department_id') . $file_extension);

            $department = Department::find($add_department);
            $department->logo = $file_path;
            $department->save();
        }

        if ($request->input('user_id')) {
            //очистим записи о всех юзерах этого департмента
            Department::clearDepartmentUsers($request->input('department_id'));

            foreach ($request->input('user_id') as $user_id) {
                //добавляем в департамент указанных юзеров
                DB::table('users_departments')->insert(['user_id' => $user_id, 'department_id' => $add_department]);
            }
        }

        if ($add_department) {
            return view('departments.create_department');
        } else {
            return 'create department error';
        }
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
        $add_department = Department::where('id', '=', $request->input('department_id'))->update([
            'name' => $request->input('department_name'),
            'description' => $request->input('deparment_descr'),
        ]);

        if ($request->file('deparment_logo')) {
            $file_extension = "." . $request->file('deparment_logo')->getClientOriginalExtension();

            $file_path = $request->file('deparment_logo')->storeAs('images', $request->input('department_id') . $file_extension);

            Department::where('id', '=', $request->input('department_id'))->update(['logo' => $file_path]);
        }

        Department::setDepartmentUsers($request);

        if ($add_department) {
            return view('departments.update_department');
        } else {
            return 'update deparment problem';
        }
    }
}
