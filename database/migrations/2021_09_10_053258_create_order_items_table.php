<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restaurant_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->string('menu_name', 150)->nullable();
            $table->string('menu_type', 40)->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 16, 2)->nullable();
            $table->decimal('discount')->nullable();
            $table->string('discount_type', 20)->nullable();
            $table->decimal('total', 16, 2)->nullable();
            $table->string('status', 20)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
