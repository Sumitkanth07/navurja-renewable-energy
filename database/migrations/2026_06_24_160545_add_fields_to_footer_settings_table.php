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
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->text('footer_description')->nullable()->after('company_name');
            $table->string('alternate_phone')->nullable()->after('phone');
            $table->text('map_url')->nullable()->after('address');
            $table->string('whatsapp_number')->nullable()->after('copyright_text');
            $table->text('whatsapp_message')->nullable()->after('whatsapp_number');
            $table->boolean('whatsapp_enabled')->default(true)->after('whatsapp_message');
            $table->string('footer_logo')->nullable()->after('company_name');
            $table->string('facebook_url')->nullable()->after('copyright_text');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('youtube_url')->nullable()->after('linkedin_url');
            $table->string('twitter_url')->nullable()->after('youtube_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_logo',
                'footer_description',
                'alternate_phone',
                'map_url',
                'whatsapp_number',
                'whatsapp_message',
                'whatsapp_enabled',
                'facebook_url',
                'instagram_url',
                'linkedin_url',
                'youtube_url',
                'twitter_url',
            ]);
        });
    }
};
