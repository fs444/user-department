<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;

use App\User;

use Illuminate\Support\Facades\DB;

class DepartmentsControllerNew extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //отображаем список пользователей
        $user_list = User::all();

        return view('departments.add_department', ['user_list' => $user_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

//        return view('departments.create_department');
        return redirect('/departments')->with('add_dep_name', $request->input('department_name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $department_id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

//        return view('departments.update_department');
        return redirect('/departments')->with('edit_dep_name', $request->input('department_name'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($department_id)
    {
        //проверим, есть ли у департмента пользователи
        $user_in_department = DB::table('users_departments')->where('department_id', '=', $department_id)->count();

        if ($user_in_department == 0) {
            $department = Department::find($department_id);
            
            $department_name = $department->name;

            $department->deleteDepartmentImg($department->logo);

            $department->delete();

//            return view('departments.delete_department');
            return redirect('/departments')->with('delete_dep_name', $department_name);
        } else {
//            return view('departments.not_delete_department');
            return redirect('/departments')->with('not_delete_dep_name', '1');
        }
    }
}
