<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('wargas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('keluarga_id')->constrained()->onDelete('cascade');
        $table->string('nik', 20)->unique();
        $table->string('nama', 100);
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('tempat_lahir', 50);
        $table->date('tanggal_lahir');
        $table->enum('status_dalam_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Lainnya']);
        $table->string('pendidikan', 50);
        $table->string('pekerjaan', 100)->nullable();
        $table->timestamps();
    });
}
};