<?php

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCostToProject extends Migration
{
    public function up()
    {
        Schema::table(Project::table(), function (Blueprint $table) {
            $table->unsignedInteger('cost');
        });
    }

    public function down()
    {
        Schema::table(Project::table(), function (Blueprint $table) {
            $table->dropColumn('cost');
        });
    }
}
