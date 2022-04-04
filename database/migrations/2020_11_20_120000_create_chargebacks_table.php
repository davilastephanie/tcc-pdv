<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargebacksTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('chargebacks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->unsignedInteger('quantity');
            $table->text('note');

            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chargebacks');
    }
}
