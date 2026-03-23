<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('article_blocks');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('categories');
    }

    public function down(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('show_in_menu')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover_path')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_main_for_category')->default(false);
            $table->timestamps();
        });

        Schema::create('article_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->integer('position')->default(0);
            $table->string('type');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }
};
