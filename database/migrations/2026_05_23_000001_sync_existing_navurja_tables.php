<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $this->ensure('settings', ['key' => fn (Blueprint $t) => $t->string('key')->nullable()->unique(), 'value' => fn (Blueprint $t) => $t->longText('value')->nullable(), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('blogs', ['blog_category_id' => fn (Blueprint $t) => $t->unsignedBigInteger('blog_category_id')->nullable(), 'title' => fn (Blueprint $t) => $t->string('title')->nullable(), 'slug' => fn (Blueprint $t) => $t->string('slug')->nullable(), 'featured_image' => fn (Blueprint $t) => $t->string('featured_image')->nullable(), 'content' => fn (Blueprint $t) => $t->longText('content')->nullable(), 'meta_title' => fn (Blueprint $t) => $t->string('meta_title')->nullable(), 'meta_description' => fn (Blueprint $t) => $t->text('meta_description')->nullable(), 'is_published' => fn (Blueprint $t) => $t->boolean('is_published')->default(false), 'published_at' => fn (Blueprint $t) => $t->timestamp('published_at')->nullable(), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('projects', ['title' => fn (Blueprint $t) => $t->string('title')->nullable(), 'image' => fn (Blueprint $t) => $t->string('image')->nullable(), 'description' => fn (Blueprint $t) => $t->text('description')->nullable(), 'is_active' => fn (Blueprint $t) => $t->boolean('is_active')->default(true), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('services', ['title' => fn (Blueprint $t) => $t->string('title')->nullable(), 'description' => fn (Blueprint $t) => $t->text('description')->nullable(), 'icon' => fn (Blueprint $t) => $t->string('icon')->nullable(), 'sort_order' => fn (Blueprint $t) => $t->integer('sort_order')->default(0), 'is_active' => fn (Blueprint $t) => $t->boolean('is_active')->default(true), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
    }

    private function ensure(string $table, array $columns): void
    {
        if (! Schema::hasTable($table)) return;
        Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
            foreach ($columns as $column => $definition) {
                if (! Schema::hasColumn($table, $column)) $definition($blueprint);
            }
        });
    }
};
