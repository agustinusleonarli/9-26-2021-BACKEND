<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('NIM');
            // mendefinisikan type
            $table->enum('jeniskelamin', ['Laki-Laki', 'Perempuan']);
            $table->enum('prodi', ['Teknik Informatika', 'Sistem Informasi', 'Sistem Komputer']);
            $table->timestamp('time') ->default(now());
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
        Schema::dropIfExists('mahasiswas');
    }
}
