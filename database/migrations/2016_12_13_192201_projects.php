<?php

use App\Models\Project;
use App\Models\ProjectGroup;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    public function up()
    {
        Schema::create(Project::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->char('color', 16);
            $table->timestamp('ends_at');
            $table->timestamps();
        });
//        DB::statement('ALTER TABLE ' . Project::table() . ' ADD FULLTEXT full(name)');


        Schema::create(ProjectGroup::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
//        DB::statement('ALTER TABLE ' . ProjectGroup::table() . ' ADD FULLTEXT full(name)');


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
