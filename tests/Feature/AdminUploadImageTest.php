<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

test('plant uploads are converted to webp in public images plants', function () {
    Str::createUuidsUsing(fn () => '11111111-1111-1111-1111-111111111111');

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('admin.upload.image'), [
        'collection' => 'plants',
        'image' => UploadedFile::fake()->image('plant.jpg', 2400, 1800),
    ]);

    $response->assertOk();
    $response->assertJson([
        'url' => asset('images/plants/11111111-1111-1111-1111-111111111111.webp'),
    ]);

    expect(file_exists(public_path('images/plants/11111111-1111-1111-1111-111111111111.webp')))->toBeTrue();

    @unlink(public_path('images/plants/11111111-1111-1111-1111-111111111111.webp'));
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
