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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('slug')->after('name')->nullable()->unique();
        });

        // Optional: Populate slugs for existing records
        // DB::table('restaurants')->get()->each(function ($restaurant) {
        //     DB::table('restaurants')
        //         ->where('id', $restaurant->id)
        //         ->update(['slug' => Str::slug($restaurant->name)]);
        // });
        
        // Make slug required after population
        Schema::table('restaurants', function (Blueprint $table) {
             $table->string('slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
