<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $this->ensure('calculator_settings', ['cost_per_kw' => fn (Blueprint $t) => $t->decimal('cost_per_kw', 10, 2)->default(55000), 'monthly_savings_rate' => fn (Blueprint $t) => $t->decimal('monthly_savings_rate', 5, 2)->default(.82), 'co2_per_kw_year' => fn (Blueprint $t) => $t->decimal('co2_per_kw_year', 8, 2)->default(1.25), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('cities', ['name' => fn (Blueprint $t) => $t->string('name')->nullable(), 'sun_factor' => fn (Blueprint $t) => $t->decimal('sun_factor', 4, 2)->default(1), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('footer_settings', ['company_name' => fn (Blueprint $t) => $t->string('company_name')->nullable(), 'email' => fn (Blueprint $t) => $t->string('email')->nullable(), 'phone' => fn (Blueprint $t) => $t->string('phone')->nullable(), 'address' => fn (Blueprint $t) => $t->text('address')->nullable(), 'copyright_text' => fn (Blueprint $t) => $t->string('copyright_text')->nullable(), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('homepage_sections', ['key' => fn (Blueprint $t) => $t->string('key')->nullable(), 'title' => fn (Blueprint $t) => $t->string('title')->nullable(), 'subtitle' => fn (Blueprint $t) => $t->text('subtitle')->nullable(), 'content' => fn (Blueprint $t) => $t->longText('content')->nullable(), 'image' => fn (Blueprint $t) => $t->string('image')->nullable(), 'extra' => fn (Blueprint $t) => $t->json('extra')->nullable(), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('navigation_items', ['label' => fn (Blueprint $t) => $t->string('label')->nullable(), 'url' => fn (Blueprint $t) => $t->string('url')->nullable(), 'sort_order' => fn (Blueprint $t) => $t->integer('sort_order')->default(0), 'is_active' => fn (Blueprint $t) => $t->boolean('is_active')->default(true), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('redirects', ['old_url' => fn (Blueprint $t) => $t->string('old_url')->nullable(), 'new_url' => fn (Blueprint $t) => $t->string('new_url')->nullable(), 'status_code' => fn (Blueprint $t) => $t->unsignedSmallInteger('status_code')->default(301), 'is_active' => fn (Blueprint $t) => $t->boolean('is_active')->default(true), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
        $this->ensure('blog_categories', ['name' => fn (Blueprint $t) => $t->string('name')->nullable(), 'slug' => fn (Blueprint $t) => $t->string('slug')->nullable(), 'created_at' => fn (Blueprint $t) => $t->timestamp('created_at')->nullable(), 'updated_at' => fn (Blueprint $t) => $t->timestamp('updated_at')->nullable()]);
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
