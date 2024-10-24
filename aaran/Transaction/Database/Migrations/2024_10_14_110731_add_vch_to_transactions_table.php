<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('vch_no',8,2)->nullable()->after('contact_id');
        });
    }


    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('vch_no');
        });
    }
};
