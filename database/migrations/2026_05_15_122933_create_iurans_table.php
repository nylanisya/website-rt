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
    Schema::create('iurans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('keluarga_id')->constrained()->onDelete('cascade');
        $table->foreignId('jenis_iuran_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_tagihan');
        $table->date('tanggal_jatuh_tempo');
        $table->enum('status', ['lunas', 'belum'])->default('belum');
        $table->timestamps();
    });
}
};
