<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Department extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'logo'
    ];

    /**
     * Отображаем пользователей конкретного департамента
     *
     * @param int $department_id
     *
     * @return string
     */
    public static function departmentUsers($department_id)
    {
        $users_department = Department::find($department_id)->users()->get();

        echo "<ol>";

        foreach ($users_department as $user) {
            echo "<li>" . $user->name . "</li>";
        }

        echo "</ol>";
    }
    
    /**
     *
     * Очищаем список пользователей, прикрепленных к отделу
     *
     * @param int $department_id
     *
     * @return void
     */
    public function clearDepartmentUsers($department_id)
    {
        DB::table('users_departments')->where('department_id', '=', $department_id)->delete();
    }

    /**
     *
     * Указываем полученных пользователей для отдела
     *
     * @param array $user_id_arr
     * @param int $department_id
     *
     * @return void
     */
    public function addDepartmentUsers($user_id_arr, $department_id)
    {
        $this->clearDepartmentUsers($department_id);
        
        if (!empty($user_id_arr)) {
            foreach ($user_id_arr as $user_id) {
                //добавляем в департамент указанных юзеров
                DB::table('users_departments')->insert(['user_id' => $user_id, 'department_id' => $department_id]);
            }
        }
    }

    /**
     * Получаем список пользователей, входящих в отдел
     *
     * @return void
     */
    public function users()
    {
      return $this->belongsToMany('App\User', 'users_departments', 'department_id', 'user_id');
    }
}
