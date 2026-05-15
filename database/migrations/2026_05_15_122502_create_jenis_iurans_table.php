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
    Schema::create('jenis_iurans', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->text('deskripsi')->nullable();
        $table->integer('nominal');
        $table->enum('periode', ['bulanan', 'tahunan', 'sekali']);
        $table->timestamps();
    });
}
};
