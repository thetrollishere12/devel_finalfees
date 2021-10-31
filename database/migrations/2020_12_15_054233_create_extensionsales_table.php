<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtensionsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensionsales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->date('sale_date')->nullable();
            $table->string('order_id');
            $table->string('platform');
            $table->string('currency');
            $table->string('name');
            $table->string('img');
            $table->decimal('sold_price', 65,2);
            $table->decimal('shipping', 65,2);
            $table->decimal('fees', 65,2);
            $table->decimal('tax', 65,2);
            $table->decimal('total', 65,2);
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
        Schema::dropIfExists('extensionsales');
    }
}
