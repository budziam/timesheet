<?php

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkLogs extends Migration
{
    public function up()
    {
        Schema::create(WorkLog::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_id');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on(User::table())
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on(Project::table())
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists(WorkLog::table());
    }
}
