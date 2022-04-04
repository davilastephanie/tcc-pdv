<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('orders_products', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->unsignedDouble('price', 14, 2);
            $table->unsignedInteger('quantity');
            $table->unsignedDouble('total', 14, 2);

            $table->primary(['order_id', 'product_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
}
