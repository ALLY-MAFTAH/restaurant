<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watercom_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->date('date');
            $table->bigInteger('product_id');
            $table->bigInteger('stock_id');
            $table->string('name');
            $table->string('user_name');
            $table->string('container');
            $table->double('quantity');
            $table->double('volume');
            $table->string('unit');
            $table->double('price');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watercom_sales');
    }
};
