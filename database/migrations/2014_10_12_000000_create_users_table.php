<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('gambar')->nullable();
            // 0 petugas, 1 admin, 2 root
            $table->enum('level',['0', '1', '2'])->default('0');
            //  0 belum verifikasi email, 1 sudah verifikasi email namun belum di setujui mengakses menu tps, 2 disetujui mengakses menu tps
            $table->enum('status',['0', '1', '2'])->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
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
