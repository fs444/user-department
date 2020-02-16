<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users_departments')) {
            Schema::table('users_departments', function (Blueprint $table) {
                $table->index('department_id');
                $table->foreign('department_id')->references('id')->on('departments');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users_departments')) {
            Schema::table('users_departments', function (Blueprint $table) {
                $table->dropForeign('users_departments_department_id_foreign');
            });
        }
    }
}
