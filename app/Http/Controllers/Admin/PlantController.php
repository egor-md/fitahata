<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantNutritionItem;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PlantController extends Controller
{
    public function index(): Response
    {
        $plants = Plant::query()->orderByDesc('updated_at')->get();

        return Inertia::render('admin/plants/index', [
            'plants' => $plants,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/plants/create', [
            'tags' => Tag::orderBy('name')->get(),
            'plant_kinds' => $this->plantKindOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedPlant($request);
        $plant = Plant::create($validated['plant']);
        $this->syncImages($plant, $validated['images']);
        $plant->tags()->sync($validated['tag_ids']);
        $this->syncNutritionItems($plant, $validated['nutrition_items']);

        return redirect()->route('admin.plants.index');
    }

    public function edit(Plant $plant): Response
    {
        $plant->load(['images', 'tags', 'nutritionItems']);

        return Inertia::render('admin/plants/edit', [
            'plant' => $plant,
            'tags' => Tag::orderBy('name')->get(),
            'plant_kinds' => $this->plantKindOptions(),
        ]);
    }

    public function update(Request $request, Plant $plant): RedirectResponse
    {
        $validated = $this->validatedPlant($request, $plant);
        $plant->update($validated['plant']);
        $this->syncImages($plant, $validated['images']);
        $plant->tags()->sync($validated['tag_ids']);
        $this->syncNutritionItems($plant, $validated['nutrition_items']);

        return redirect()->route('admin.plants.index');
    }

    public function destroy(Plant $plant): RedirectResponse
    {
        $plant->delete();

        return redirect()->route('admin.plants.index');
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    private function plantKindOptions(): array
    {
        return [
            ['value' => Plant::KIND_MICROGREEN, 'label' => 'Микрозелень'],
            ['value' => Plant::KIND_BABY_LEAF, 'label' => 'Baby leaf'],
            ['value' => Plant::KIND_MATURE, 'label' => 'Взрослая зелень'],
            ['value' => Plant::KIND_EDIBLE_FLOWERS, 'label' => 'Съедобные цветы'],
        ];
    }

    /**
     * @return array{plant: array<string, mixed>, images: list<array<string, mixed>>, tag_ids: list<int>, nutrition_items: list<array<string, mixed>>}
     */
    private function validatedPlant(Request $request, ?Plant $plant = null): array
    {
        $slugRule = Rule::unique('plants', 'slug');
        if ($plant) {
            $slugRule = $slugRule->ignore($plant->id);
        }

        $plantRules = [
            'name' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugRule],
            'kind' => ['required', 'string', Rule::in([
                Plant::KIND_MICROGREEN,
                Plant::KIND_BABY_LEAF,
                Plant::KIND_MATURE,
                Plant::KIND_EDIBLE_FLOWERS,
            ])],
            'is_visible' => ['boolean'],
            'description' => ['nullable', 'string'],
            'dishes_text' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_unit_label' => ['nullable', 'string', 'max:255'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'discount_label' => ['nullable', 'string', 'max:255'],
            'growing_period_label' => ['nullable', 'string', 'max:255'],
            'category_label' => ['nullable', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'is_bestseller' => ['boolean'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'reviews_count' => ['nullable', 'integer', 'min:0'],
            'facts' => ['nullable', 'array'],
            'facts.*.icon' => ['required_with:facts', 'string', 'max:255'],
            'facts.*.title' => ['required_with:facts', 'string', 'max:255'],
            'facts.*.sub' => ['nullable', 'string', 'max:255'],
            'nutrition_section_title' => ['nullable', 'string', 'max:255'],
            'nutrition_section_lead' => ['nullable', 'string'],
            'nutrition_tip_text' => ['nullable', 'string'],
            'recipes_section_pill' => ['nullable', 'string', 'max:255'],
            'recipes_section_title' => ['nullable', 'string', 'max:255'],
            'recipes_section_lead' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*.url' => ['required', 'string', 'max:2048'],
            'images.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'images.*.is_primary' => ['boolean'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'nutrition_items' => ['nullable', 'array'],
            'nutrition_items.*.section' => ['required', 'string', Rule::in([
                PlantNutritionItem::SECTION_ENERGY,
                PlantNutritionItem::SECTION_PROTEIN,
                PlantNutritionItem::SECTION_VITAMINS,
                PlantNutritionItem::SECTION_MINERALS,
                PlantNutritionItem::SECTION_ANTIOXIDANTS,
            ])],
            'nutrition_items.*.label' => ['required', 'string', 'max:255'],
            'nutrition_items.*.meta' => ['nullable', 'string', 'max:255'],
            'nutrition_items.*.value' => ['required', 'string', 'max:255'],
            'nutrition_items.*.bar_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'nutrition_items.*.bar_variant' => ['nullable', 'string', 'max:64'],
            'nutrition_items.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ];

        $validated = $request->validate($plantRules);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');

        $images = $validated['images'] ?? [];
        foreach ($images as $i => &$img) {
            $img['sort_order'] = (int) ($img['sort_order'] ?? $i);
            $img['is_primary'] = filter_var($img['is_primary'] ?? false, FILTER_VALIDATE_BOOLEAN);
        }
        unset($img);

        $nutritionItems = $validated['nutrition_items'] ?? [];
        foreach ($nutritionItems as $i => &$row) {
            $row['bar_percent'] = (int) ($row['bar_percent'] ?? 0);
            $row['sort_order'] = (int) ($row['sort_order'] ?? $i);
            $row['bar_variant'] = $row['bar_variant'] ?? '';
        }
        unset($row);

        $plantPayload = collect($validated)->except(['images', 'tag_ids', 'nutrition_items'])->all();
        $plantPayload['price_unit_label'] = $plantPayload['price_unit_label'] ?: 'за 50 г';
        if ($plantPayload['compare_at_price'] === '' || $plantPayload['compare_at_price'] === null) {
            $plantPayload['compare_at_price'] = null;
        }
        if ($plantPayload['rating'] === '' || $plantPayload['rating'] === null) {
            $plantPayload['rating'] = null;
        }

        return [
            'plant' => $plantPayload,
            'images' => $images,
            'tag_ids' => array_map('intval', $validated['tag_ids'] ?? []),
            'nutrition_items' => $nutritionItems,
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $images
     */
    private function syncImages(Plant $plant, array $images): void
    {
        $plant->images()->delete();
        usort($images, fn ($a, $b) => ($a['sort_order'] ?? 0) <=> ($b['sort_order'] ?? 0));
        $primaryIndex = null;
        foreach ($images as $i => $img) {
            if (! empty($img['is_primary'])) {
                $primaryIndex = $i;
                break;
            }
        }
        if ($primaryIndex === null && $images !== []) {
            $primaryIndex = 0;
        }
        foreach ($images as $i => $img) {
            $plant->images()->create([
                'url' => $img['url'],
                'sort_order' => (int) ($img['sort_order'] ?? $i),
                'is_primary' => $primaryIndex !== null && $i === $primaryIndex,
            ]);
        }
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     */
    private function syncNutritionItems(Plant $plant, array $rows): void
    {
        $plant->nutritionItems()->delete();
        foreach ($rows as $row) {
            $plant->nutritionItems()->create([
                'section' => $row['section'],
                'label' => $row['label'],
                'meta' => $row['meta'] ?? null,
                'value' => $row['value'],
                'bar_percent' => (int) ($row['bar_percent'] ?? 0),
                'bar_variant' => $row['bar_variant'] ?? '',
                'sort_order' => (int) ($row['sort_order'] ?? 0),
            ]);
        }
    }
}
