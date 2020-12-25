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
            $table->string('kode');
            $table->string('name');
            $table->string('sapaan');
            $table->string('panggilan');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image');
            $table->string('phone');
            $table->string('alamat');
            $table->text('alamat_lengkap');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->integer('komisi');
            $table->bigInteger('pendapatan');
            $table->integer('status');
            $table->string('role');
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
