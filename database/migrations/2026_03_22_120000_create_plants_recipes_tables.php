<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->string('kind', 32);
            $table->boolean('is_visible')->default(true);
            $table->longText('description')->nullable();
            $table->text('dishes_text')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('price_unit_label')->default('за 50 г');
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->string('discount_label')->nullable();
            $table->string('growing_period_label')->nullable();
            $table->string('category_label')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('is_bestseller')->default(false);
            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedInteger('reviews_count')->default(0);
            $table->json('facts')->nullable();
            $table->string('nutrition_section_title')->nullable();
            $table->text('nutrition_section_lead')->nullable();
            $table->text('nutrition_tip_text')->nullable();
            $table->string('recipes_section_pill')->nullable();
            $table->string('recipes_section_title')->nullable();
            $table->text('recipes_section_lead')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('plant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create('plant_tag', function (Blueprint $table) {
            $table->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['plant_id', 'tag_id']);
        });

        Schema::create('plant_nutrition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $table->string('section', 32);
            $table->string('label');
            $table->string('meta')->nullable();
            $table->string('value');
            $table->unsignedTinyInteger('bar_percent')->default(0);
            $table->string('bar_variant', 64)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image_url');
            $table->string('time_label')->nullable();
            $table->string('calories_label')->nullable();
            $table->string('difficulty_label')->nullable();
            $table->string('tag_top')->nullable();
            $table->string('tag_bottom')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->json('ingredients')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('plant_recipe', function (Blueprint $table) {
            $table->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->primary(['plant_id', 'recipe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_recipe');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('plant_nutrition_items');
        Schema::dropIfExists('plant_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('plant_images');
        Schema::dropIfExists('plants');
    }
};
