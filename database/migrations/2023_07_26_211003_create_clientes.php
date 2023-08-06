<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('id_asaas')->nullable();
            $table->unsignedBigInteger('usuario_criacao');
            $table->unsignedBigInteger('usuario_atualizacao')->nullable();
            $table->date('data_aniversario')->nullable();
            $table->string('cpf_cnpj');
            $table->boolean('status')->default(true);
            $table->string('observacao')->nullable();
            $table->timestamps();
            $table->foreign('usuario_criacao')->references('id')->on('users');
            $table->foreign('usuario_atualizacao')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
