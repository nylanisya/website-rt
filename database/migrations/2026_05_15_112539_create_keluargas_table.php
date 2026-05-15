<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keluargas', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 20)->unique();
            $table->string('kepala_keluarga', 100);
            $table->text('alamat');
            $table->string('rt', 5)->default('01');
            $table->string('rw', 5)->default('03');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keluargas');
    }
};