<?php

use App\Models\Project;
use App\Models\ProjectGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Projects extends Migration
{
    public function up()
    {
        Schema::create(Project::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('lkz', 16);
            $table->string('kerg', 32);
            $table->string('name');
            $table->text('description');
            $table->char('color', 16)->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();

            $table->unique('lkz');
        });

        Schema::create(ProjectGroup::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('color', 16);
            $table->timestamps();
        });

        Schema::create('project_project_group', function (Blueprint $table) {
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('project_group_id');

            $table->unique(['project_id', 'project_group_id']);

            $table->foreign('project_id')
                ->references('id')
                ->on(Project::table())
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('project_group_id')
                ->references('id')
                ->on(ProjectGroup::table())
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists(ProjectGroup::table());
        Schema::dropIfExists(Project::table());
    }
}
