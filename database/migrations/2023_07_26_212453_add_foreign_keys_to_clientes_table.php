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
        Schema::table('clientes', function (Blueprint $table) {
            // Chave estrangeira para a tabela "enderecos" e telefones
            $table->unsignedBigInteger('endereco')->nullable();
            $table->foreign('endereco')->references('id')->on('enderecos');
            $table->unsignedBigInteger('telefone')->nullable();
            $table->foreign('telefone')->references('id')->on('telefones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
};
