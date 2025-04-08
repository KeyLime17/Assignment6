<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->boolean('ltc')->default(false);
            $table->boolean('xrp')->default(false);
            $table->boolean('bch')->default(false);
            $table->boolean('eos')->default(false);
            $table->boolean('bnb')->default(false);
            $table->boolean('ada')->default(false);
            $table->boolean('dot')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            //
        });
    }
};
