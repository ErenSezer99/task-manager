<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        DB::table('tasks')->get()->each(function ($task) {
            DB::table('tasks')
                ->where('id', $task->id)
                ->update(['uuid' => Str::uuid()]);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }
};
