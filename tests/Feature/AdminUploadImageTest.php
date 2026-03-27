<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

test('catalog plant uploads are converted to webp with square variants in public images catalog', function () {
    Str::createUuidsUsing(fn () => '11111111-1111-1111-1111-111111111111');

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('admin.upload.image'), [
        'collection' => 'catalog',
        'image' => UploadedFile::fake()->image('plant.jpg', 2400, 1800),
    ]);

    $response->assertOk();
    $response->assertJson([
        'url' => asset('images/catalog/11111111-1111-1111-1111-111111111111.webp'),
    ]);

    expect(file_exists(public_path('images/catalog/11111111-1111-1111-1111-111111111111.webp')))->toBeTrue();
    expect(file_exists(public_path('images/catalog/11111111-1111-1111-1111-111111111111_160.webp')))->toBeTrue();
    expect(file_exists(public_path('images/catalog/11111111-1111-1111-1111-111111111111_300.webp')))->toBeTrue();
    expect(file_exists(public_path('images/catalog/11111111-1111-1111-1111-111111111111_640.webp')))->toBeTrue();

    @unlink(public_path('images/catalog/11111111-1111-1111-1111-111111111111.webp'));
    @unlink(public_path('images/catalog/11111111-1111-1111-1111-111111111111_160.webp'));
    @unlink(public_path('images/catalog/11111111-1111-1111-1111-111111111111_300.webp'));
    @unlink(public_path('images/catalog/11111111-1111-1111-1111-111111111111_640.webp'));
    Str::createUuidsNormally();
});

test('legacy plants collection alias writes to catalog', function () {
    Str::createUuidsUsing(fn () => '33333333-3333-3333-3333-333333333333');

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('admin.upload.image'), [
        'collection' => 'plants',
        'image' => UploadedFile::fake()->image('p.jpg', 400, 400),
    ]);

    $response->assertOk();
    $response->assertJson([
        'url' => asset('images/catalog/33333333-3333-3333-3333-333333333333.webp'),
    ]);

    @unlink(public_path('images/catalog/33333333-3333-3333-3333-333333333333.webp'));
    @unlink(public_path('images/catalog/33333333-3333-3333-3333-333333333333_160.webp'));
    @unlink(public_path('images/catalog/33333333-3333-3333-3333-333333333333_300.webp'));
    @unlink(public_path('images/catalog/33333333-3333-3333-3333-333333333333_640.webp'));
    Str::createUuidsNormally();
});

test('recipe uploads are converted to webp in public images recipes', function () {
    Str::createUuidsUsing(fn () => '22222222-2222-2222-2222-222222222222');

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('admin.upload.image'), [
        'collection' => 'recipes',
        'image' => UploadedFile::fake()->image('recipe.png', 1600, 1200),
    ]);

    $response->assertOk();
    $response->assertJson([
        'url' => asset('images/recipes/22222222-2222-2222-2222-222222222222.webp'),
    ]);

    expect(file_exists(public_path('images/recipes/22222222-2222-2222-2222-222222222222.webp')))->toBeTrue();

    @unlink(public_path('images/recipes/22222222-2222-2222-2222-222222222222.webp'));
    Str::createUuidsNormally();
});
