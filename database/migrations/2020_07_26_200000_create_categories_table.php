<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
