<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('cpf', 14)->unique();
            $table->string('rg', 10);
            $table->date('birthday');
            $table->string('email');
            $table->string('phone', 15);
            $table->string('cep', 9);
            $table->string('address');
            $table->string('number', 15);
            $table->string('neighborhood');
            $table->string('city');
            $table->char('uf', 2);

            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
