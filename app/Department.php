<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
     *
     * Отображаем путь к картинке отдела или к картинке по умолчанию
     *
     * @param string $storage_path
     * @param string $logo
     *
     * @return string
     */
    public function showDepartmentImg($storage_path, $logo)
    {
        if (Storage::disk('public')->exists($logo)) {
            $path = $storage_path . "/" . $logo;
        } else {
            $path = "/images/default.jpg";
        }

        echo $path;
    }

    /**
     *
     * Удаляем картинку при удалении отдела
     *
     * @param string $image_path
     *
     * return void
     *
     */
    public function deleteDepartmentImg($image_path)
    {
        Storage::disk('public')->delete($image_path);
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
