<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('transaction_point_id')->nullable();
            $table->foreign('transaction_point_id')->references('id')->on('transaction_points');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->mediumText('avatar');
            $table->integer('gender');
            $table->string('address');
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->string('profile_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
