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
            // Composite index for Geospatial queries (Haversine)
            // Most queries filter by bounding box or sort by distance which uses both lat/long
            $table->index(['latitude', 'longitude'], 'restaurants_lat_long_index');

            // Index for search queries
            $table->index('name');
            $table->index('cuisine_type');
            
            // Note: Fulltext index might be better for 'name' and 'description' in MySQL,
            // but standard B-Tree is safer for broad compatibility (if SQLite is used for testing)
            // and sufficient for 'LIKE %...%' or specific matches in many cases, 
            // though 'LIKE %...%' doesn't use left-prefix index efficiently.
            // However, 'cuisine_type' is often an exact match filter.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropIndex('restaurants_lat_long_index');
            $table->dropIndex(['name']);
            $table->dropIndex(['cuisine_type']);
        });
    }
};
