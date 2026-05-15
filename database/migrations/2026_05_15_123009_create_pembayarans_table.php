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
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('iuran_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_bayar');
        $table->integer('jumlah_bayar');
        $table->enum('metode', ['tunai', 'transfer'])->default('tunai');
        $table->string('bukti')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}
};
