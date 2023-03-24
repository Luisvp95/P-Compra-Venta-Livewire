<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('name')->unique();
            $table->integer('stock')->default(0);
            $table->string('image');
            $table->decimal('sell_price', 12,2);
            $table->enum('status', ['ACTIVE','DEACTIVATED'])->default('ACTIVE');

            $table->unsignedBigInteger('category_id');
            
            $table->unsignedBigInteger('provider_id');
            
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('user_id')->references('id')->on('users');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
