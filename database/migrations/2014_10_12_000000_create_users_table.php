<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->unsignedBigInteger('equipe_id')->nullable();
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('set null');
            $table->timestamps();
        });

        // Adicione o usuário administrador
        $admin = [
            'name' => 'Administrador',
            'login' => 'admin',
            'password' => Hash::make('Realtech@10'),
            'email' => 'admin@example.com',
            'equipe_id' => null,
            'created_at' => '2023-01-01 10:10:10',
            'updated_at' => '2023-01-01 10:10:10',
        ];

        DB::table('users')->insert($admin);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
