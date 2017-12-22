<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Customers extends Migration
{
    public function up()
    {
        Schema::create(Customer::table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('color', 16);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Customer::table());
    }
}
