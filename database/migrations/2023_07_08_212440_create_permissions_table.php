<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('last_modified_by')->nullable();
            $table->boolean('configuracoes')->default(false);
            $table->boolean('rh')->default(false);
            $table->boolean('cadastros')->default(false);
            $table->boolean('gerencia')->default(false);
            $table->boolean('financeiro')->default(false);
            $table->boolean('execucao')->default(false);
            $table->boolean('importacoes')->default(false);
            $table->boolean('processo')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('last_modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
