<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('restaurant_id')->nullable();
            $table->string('order_no', 50)->nullable();
            $table->decimal('sub_total')->nullable();
            $table->integer('coins')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->decimal('delivery_charge')->nullable();
            $table->string('tax', 150)->nullable();
            $table->decimal('total_amount', 16, 2)->nullable();
            $table->string('txn_id', 150)->nullable();
            $table->string('txn_status', 40)->nullable();
            $table->string('payment_mode', 20)->nullable();
            $table->json('delivery_address')->nullable();
            $table->bigInteger('delivery_boy_id')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('delivery_notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
