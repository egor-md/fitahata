<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class RecipeController extends Controller
{
    public function index(): Response
    {
        $recipes = Recipe::query()->orderBy('sort_order')->orderBy('title')->get();

        return Inertia::render('admin/recipes/index', [
            'recipes' => $recipes,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/recipes/create', [
            'plants' => Plant::orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedRecipe($request);
        $recipe = Recipe::create($validated['recipe']);
        $recipe->plants()->sync($validated['plant_ids']);

        return redirect()->route('admin.recipes.index');
    }

    public function edit(Recipe $recipe): Response
    {
        $recipe->load('plants');

        return Inertia::render('admin/recipes/edit', [
            'recipe' => $recipe,
            'plants' => Plant::orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $validated = $this->validatedRecipe($request, $recipe);
        $recipe->update($validated['recipe']);
        $recipe->plants()->sync($validated['plant_ids']);

        return redirect()->route('admin.recipes.index');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();

        return redirect()->route('admin.recipes.index');
    }

    /**
     * @return array{recipe: array<string, mixed>, plant_ids: list<int>}
     */
    private function validatedRecipe(Request $request, ?Recipe $recipe = null): array
    {
        $slugRule = Rule::unique('recipes', 'slug');
        if ($recipe) {
            $slugRule = $slugRule->ignore($recipe->id);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugRule],
            'image_url' => ['required', 'string', 'max:2048'],
            'time_label' => ['nullable', 'string', 'max:255'],
            'calories_label' => ['nullable', 'string', 'max:255'],
            'difficulty_label' => ['nullable', 'string', 'max:255'],
            'tag_top' => ['nullable', 'string', 'max:255'],
            'tag_bottom' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*' => ['string', 'max:500'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'plant_ids' => ['nullable', 'array'],
            'plant_ids.*' => ['integer', 'exists:plants,id'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $plantIds = array_map('intval', $validated['plant_ids'] ?? []);
        $recipePayload = collect($validated)->except(['plant_ids'])->all();
        $recipePayload['sort_order'] = (int) ($recipePayload['sort_order'] ?? 0);
        $recipePayload['ingredients'] = array_values($recipePayload['ingredients'] ?? []);
        foreach (['excerpt', 'body'] as $textField) {
            if (array_key_exists($textField, $recipePayload)) {
                $recipePayload[$textField] = $this->sanitizePlainText($recipePayload[$textField] ?? null);
            }
        }

        return [
            'recipe' => $recipePayload,
            'plant_ids' => $plantIds,
        ];
    }

    private function sanitizePlainText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/\r\n?/', "\n", $value) ?? $value;
        $normalized = preg_replace('/<\s*br\s*\/?>/i', "\n", $normalized) ?? $normalized;
        $normalized = preg_replace('/<\/p>\s*<p>/i', "\n\n", $normalized) ?? $normalized;
        $plain = trim(strip_tags($normalized));

        return $plain === '' ? null : $plain;
    }
}
