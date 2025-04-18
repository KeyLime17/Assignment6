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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('frequency'); //minute hour daily
            $table->boolean('btc')->default(false);
            $table->boolean('eth')->default(false);
            $table->boolean('doge')->default(false);
            $table->boolean('ltc')->default(false);
            $table->boolean('xrp')->default(false);
            $table->boolean('bch')->default(false);
            $table->boolean('eos')->default(false);
            $table->boolean('bnb')->default(false);
            $table->boolean('ada')->default(false);
            $table->boolean('dot')->default(false);
            $table->float('percentage_alert');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
