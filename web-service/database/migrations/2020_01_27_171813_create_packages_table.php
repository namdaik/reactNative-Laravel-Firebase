<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            if ((DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')) {
                $table->json('order_ids');
            } else {
                $table->text('order_ids')->comment('Because version of MYSQL < 5.87, this column is text. But data type is json');
            }

            $table->unsignedInteger('transaction_point_id');
            $table->unsignedInteger('next_transaction_point_id')->nullable();

            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('next_employee_id')->nullable();

            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
