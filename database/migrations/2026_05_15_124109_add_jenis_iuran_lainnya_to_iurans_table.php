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
    Schema::table('iurans', function (Blueprint $table) {
        $table->string('jenis_iuran_lainnya')->nullable()->after('jenis_iuran_id');
        $table->integer('nominal')->after('jenis_iuran_lainnya');
    });
}

public function down()
{
    Schema::table('iurans', function (Blueprint $table) {
        $table->dropColumn(['jenis_iuran_lainnya', 'nominal']);
    });
}
};
