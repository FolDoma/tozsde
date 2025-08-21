<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value')->nullable();
            $table->timestamps();
        });
        
        DB::table('settings')->insert([
            'name'=> 'base_multiplier',
            'value'=> '1.3',
        ]);

        DB::table('settings')->insert([
            'name'=> 'calculate_time',
            'value'=> null,
        ]); 
    }
        
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
