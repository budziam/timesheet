<?php

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCustomerToProject extends Migration
{
    public function up()
    {
        Schema::table(Project::table(), function (Blueprint $table) {
            $table->unsignedInteger('customer_id')->nullable();

            $table->foreign('customer_id')
                ->references('id')
                ->on(Customer::table())
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table(Project::table(), function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }
}
