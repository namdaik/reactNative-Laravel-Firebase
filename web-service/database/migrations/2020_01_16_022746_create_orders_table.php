<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->unique();

            $table->unsignedInteger('place_of_shipment_id');
            $table->foreign('place_of_shipment_id')->references('id')->on('place_of_shipments');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('transaction_point_id')->nullable();
            $table->foreign('transaction_point_id')->references('id')->on('transaction_points');

            if ((DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')) {
                $table->json('receivers');
            } else {
                $table->text('receivers')->comment('Because version of MYSQL < 5.87, this column is text. But data type is json');
            }

            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->integer('price');
            $table->integer('parcel_length')->comment('chieu dai (cm)');
            $table->integer('parcel_width')->comment('chieu rong (cm)');
            $table->integer('parcel_height')->comment('chieu cao (cm)');
            $table->integer('parcel_weight')->comment('can nang (gram)');
            $table->text('parcel_description')->nullable()->comment('Mo ta hang hoa');
            $table->text('note')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_return')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
