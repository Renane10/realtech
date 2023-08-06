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
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_processo')->unique();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('usuario_criacao');
            $table->boolean('status')->default(true);
            $table->string('status_inicial')->nullable();
            $table->string('status_atual')->nullable();
            $table->string('prioridade')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('usuario_criacao')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('processos');
    }
};
