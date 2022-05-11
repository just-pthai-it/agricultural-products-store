<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up ()
    {
        Schema::table('carts', function (Blueprint $table)
        {
            $table->foreign('user_id')->on('users')->references('id');
        });

        Schema::table('products', function (Blueprint $table)
        {
            $table->foreign('category_id')->on('categories')->references('id');
            $table->foreign('product_unit_id')->on('product_units')->references('id');
        });

        Schema::table('product_batches', function (Blueprint $table)
        {
            $table->foreign('product_id')->on('products')->references('id');
        });

        Schema::table('orders', function (Blueprint $table)
        {
            $table->foreign('user_id')->on('users')->references('id');
        });

        Schema::table('order_product', function (Blueprint $table)
        {
            $table->foreign('order_id')->on('orders')->references('id');
            $table->foreign('product_id')->on('products')->references('id');
        });

        Schema::table('product_detail_image', function (Blueprint $table)
        {
            $table->foreign('product_id')->on('products')->references('id');
        });

        Schema::table('personal_access_tokens', function (Blueprint $table)
        {
            $table->foreign('tokenable_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('foreign_keys');
    }
}
