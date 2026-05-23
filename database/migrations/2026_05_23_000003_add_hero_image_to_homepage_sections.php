<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('homepage_sections') && ! Schema::hasColumn('homepage_sections', 'hero_image')) {
            Schema::table('homepage_sections', function (Blueprint $table) {
                $table->string('hero_image')->nullable()->after('image');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('homepage_sections') && Schema::hasColumn('homepage_sections', 'hero_image')) {
            Schema::table('homepage_sections', function (Blueprint $table) {
                $table->dropColumn('hero_image');
            });
        }
    }
};
