<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restaurant_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('name',100)->nullable();
            $table->string('slug')->nullable();
            $table->string('menu_type');
            $table->decimal('price', 16,2);
            $table->integer('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->text('description')->nullable();
			$table->string('status')->default('active')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
