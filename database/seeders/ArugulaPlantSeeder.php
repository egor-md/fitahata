<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\PlantImage;
use App\Models\PlantNutritionItem;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ArugulaPlantSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->seedAllTags();
            $plant = $this->seedPlant();
            $this->attachArugulaTags($plant);

            $this->seedImages($plant);
            $this->seedNutrition($plant);

            $recipes = $this->seedRecipes();
            $plant->recipes()->sync($recipes->pluck('id')->all());
        });
    }

    private function seedAllTags(): void
    {
        $defs = [
            ['name' => 'Витамин К', 'slug' => 'vitamin-k', 'group' => 'benefit'],
            ['name' => 'Кальций', 'slug' => 'calcium', 'group' => 'mineral'],
            ['name' => 'Фолиевая кислота', 'slug' => 'folate', 'group' => 'benefit'],
            ['name' => 'Антиоксиданты', 'slug' => 'antioxidants', 'group' => 'quality'],
            ['name' => 'Без ГМО', 'slug' => 'no-gmo', 'group' => 'quality'],
            ['name' => 'Витамин E', 'slug' => 'vitamin-e', 'group' => 'benefit'],
            ['name' => 'Витамин D', 'slug' => 'vitamin-d', 'group' => 'benefit'],
            ['name' => 'Витамин B1', 'slug' => 'vitamin-b1', 'group' => 'benefit'],
            ['name' => 'Витамин B6', 'slug' => 'vitamin-b6', 'group' => 'benefit'],
            ['name' => 'Витамин B12', 'slug' => 'vitamin-b12', 'group' => 'benefit'],
            ['name' => 'Ниацин', 'slug' => 'niacin', 'group' => 'benefit'],
            ['name' => 'Пантотеновая кислота', 'slug' => 'pantothenic-acid', 'group' => 'benefit'],
            ['name' => 'Цинк', 'slug' => 'zinc', 'group' => 'mineral'],
            ['name' => 'Селен', 'slug' => 'selenium', 'group' => 'mineral'],
            ['name' => 'Фосфор', 'slug' => 'phosphorus', 'group' => 'mineral'],
            ['name' => 'Марганец', 'slug' => 'manganese', 'group' => 'mineral'],
            ['name' => 'Медь', 'slug' => 'copper', 'group' => 'mineral'],
            ['name' => 'Йод', 'slug' => 'iodine', 'group' => 'mineral'],
            ['name' => 'Железо', 'slug' => 'iron', 'group' => 'mineral'],
            ['name' => 'Витамин C', 'slug' => 'vitamin-c', 'group' => 'benefit'],
            ['name' => 'Магний', 'slug' => 'magnesium', 'group' => 'mineral'],
            ['name' => 'Калий', 'slug' => 'potassium', 'group' => 'mineral'],
            ['name' => 'Клетчатка', 'slug' => 'fiber', 'group' => 'quality'],
            ['name' => 'Омега-3', 'slug' => 'omega-3', 'group' => 'benefit'],
            ['name' => 'Белок', 'slug' => 'protein-tag', 'group' => 'benefit'],
        ];

        foreach ($defs as $d) {
            Tag::query()->updateOrCreate(
                ['slug' => $d['slug']],
                ['name' => $d['name'], 'group' => $d['group']]
            );
        }
    }

    private function attachArugulaTags(Plant $plant): void
    {
        $slugs = ['vitamin-k', 'calcium', 'folate', 'antioxidants', 'no-gmo'];
        $ids = Tag::query()->whereIn('slug', $slugs)->pluck('id');
        $plant->tags()->sync($ids->all());
    }

    private function seedPlant(): Plant
    {
        return Plant::query()->updateOrCreate(
            ['slug' => 'rukola'],
            [
                'name' => 'Руккола',
                'subtitle' => 'микрозелень',
                'kind' => Plant::KIND_MICROGREEN,
                'is_visible' => true,
                'description' => '<p>Нежные ростки рукколы с характерным пряным вкусом и едва уловимой ореховой горчинкой.
                    Выращиваем без пестицидов, собираем на 7–9 день — когда концентрация питательных веществ в 40
                    раз выше, чем у взрослого растения.</p>',
                'dishes_text' => '<p>Идеальна для салатов, пиццы, пасты, тартинок и боулов. Придаёт любому блюду утончённую пряность и
                    яркую зелень.</p>',
                'price' => 5.50,
                'price_unit_label' => 'за 50 г',
                'compare_at_price' => 6.50,
                'discount_label' => 'Скидка 15%',
                'growing_period_label' => '7–9 дней',
                'category_label' => 'Зелень',
                'sku' => 'Арт. FIT-001',
                'is_bestseller' => true,
                'rating' => 4.9,
                'reviews_count' => 87,
                'facts' => [
                    ['icon' => 'ri-test-tube-line', 'title' => 'В 40× больше', 'sub' => 'питательных веществ'],
                    ['icon' => 'ri-seedling-line', 'title' => '7–9 дней', 'sub' => 'срок выращивания'],
                    ['icon' => 'ri-shield-check-line', 'title' => 'БЕЗ ГМО', 'sub' => 'и пестицидов'],
                ],
                'nutrition_section_title' => 'Таблица питательности рукколы',
                'nutrition_section_lead' => 'Микрозелень рукколы содержит в 40 раз больше питательных веществ,
                    чем взрослые растения — научно доказано',
                'nutrition_tip_text' => 'Всего 50 г рукколы FITAHATA покрывает суточную норму витамина К и даёт
                            больше кальция, чем стакан молока.',
                'recipes_section_pill' => 'Идеи для кухни',
                'recipes_section_title' => 'Готовим с рукколой',
                'recipes_section_lead' => 'Четыре простых рецепта, которые сделают рукколу FITAHATA центром вашего
                    стола',
                'meta_title' => 'Микрозелень руккола в Гомеле',
                'meta_description' => 'Микрозелень руккола в Гомеле — демо-карточка товара FITAHATA.',
            ]
        );
    }

    private function seedImages(Plant $plant): void
    {
        $plant->images()->delete();
        $rows = [
            ['url' => '/images/test-card/phero1.jpg', 'sort_order' => 0, 'is_primary' => false],
            ['url' => '/images/test-card/phero2.jpg', 'sort_order' => 1, 'is_primary' => false],
            ['url' => '/images/test-card/phero3.jpg', 'sort_order' => 2, 'is_primary' => true],
        ];
        foreach ($rows as $r) {
            PlantImage::query()->create([
                'plant_id' => $plant->id,
                'url' => $r['url'],
                'sort_order' => $r['sort_order'],
                'is_primary' => $r['is_primary'],
            ]);
        }
    }

    private function seedNutrition(Plant $plant): void
    {
        $plant->nutritionItems()->delete();
        $rows = [
            // energy
            ['section' => PlantNutritionItem::SECTION_ENERGY, 'label' => 'Калорийность', 'meta' => 'на 100 г', 'value' => '25 ккал', 'bar_percent' => 12, 'bar_variant' => ''],
            ['section' => PlantNutritionItem::SECTION_ENERGY, 'label' => 'Углеводы', 'meta' => 'на 100 г', 'value' => '3.7 г', 'bar_percent' => 30, 'bar_variant' => 'mid'],
            ['section' => PlantNutritionItem::SECTION_ENERGY, 'label' => 'Жиры', 'meta' => 'на 100 г', 'value' => '0.7 г', 'bar_percent' => 8, 'bar_variant' => 'orange'],
            // protein
            ['section' => PlantNutritionItem::SECTION_PROTEIN, 'label' => 'Белки (общие)', 'meta' => 'на 100 г', 'value' => '2.6 г', 'bar_percent' => 52, 'bar_variant' => 'prot1'],
            ['section' => PlantNutritionItem::SECTION_PROTEIN, 'label' => 'Незаменимые аминокислоты', 'meta' => 'на 100 г', 'value' => '1.1 г', 'bar_percent' => 40, 'bar_variant' => 'prot2'],
            ['section' => PlantNutritionItem::SECTION_PROTEIN, 'label' => 'Аргинин', 'meta' => 'на 100 г', 'value' => '0.14 г', 'bar_percent' => 18, 'bar_variant' => 'prot3'],
            // vitamins
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин К', 'meta' => '136% нормы', 'value' => '109 мкг', 'bar_percent' => 100, 'bar_variant' => 'vit1'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин С', 'meta' => '101% нормы', 'value' => '91 мг', 'bar_percent' => 95, 'bar_variant' => 'vit2'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Фолиевая кислота (В9)', 'meta' => '24% нормы', 'value' => '97 мкг', 'bar_percent' => 55, 'bar_variant' => 'vit3'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин А (бета-каротин)', 'meta' => '158% нормы', 'value' => '1424 мкг', 'bar_percent' => 100, 'bar_variant' => 'vit4'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин E', 'meta' => '18% нормы', 'value' => '2.7 мг', 'bar_percent' => 35, 'bar_variant' => 'vit1'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин D', 'meta' => '12% нормы', 'value' => '2.4 мкг', 'bar_percent' => 25, 'bar_variant' => 'vit2'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин B1', 'meta' => '22% нормы', 'value' => '0.27 мг', 'bar_percent' => 40, 'bar_variant' => 'vit3'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин B6', 'meta' => '28% нормы', 'value' => '0.36 мг', 'bar_percent' => 45, 'bar_variant' => 'vit4'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Витамин B12', 'meta' => '8% нормы', 'value' => '0.2 мкг', 'bar_percent' => 15, 'bar_variant' => 'vit1'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Ниацин', 'meta' => '15% нормы', 'value' => '2.4 мг НЭ', 'bar_percent' => 32, 'bar_variant' => 'vit2'],
            ['section' => PlantNutritionItem::SECTION_VITAMINS, 'label' => 'Пантотеновая кислота', 'meta' => '20% нормы', 'value' => '1.0 мг', 'bar_percent' => 38, 'bar_variant' => 'vit3'],
            // minerals
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Кальций', 'meta' => '16% нормы', 'value' => '160 мг', 'bar_percent' => 45, 'bar_variant' => 'min1'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Железо', 'meta' => '12% нормы', 'value' => '1.5 мг', 'bar_percent' => 30, 'bar_variant' => 'min2'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Магний', 'meta' => '12% нормы', 'value' => '47 мг', 'bar_percent' => 28, 'bar_variant' => 'min3'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Калий', 'meta' => '16% нормы', 'value' => '369 мг', 'bar_percent' => 40, 'bar_variant' => 'min4'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Цинк', 'meta' => '14% нормы', 'value' => '1.5 мг', 'bar_percent' => 33, 'bar_variant' => 'min1'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Селен', 'meta' => '10% нормы', 'value' => '5.5 мкг', 'bar_percent' => 22, 'bar_variant' => 'min2'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Фосфор', 'meta' => '18% нормы', 'value' => '125 мг', 'bar_percent' => 36, 'bar_variant' => 'min3'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Марганец', 'meta' => '24% нормы', 'value' => '0.48 мг', 'bar_percent' => 42, 'bar_variant' => 'min4'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Медь', 'meta' => '16% нормы', 'value' => '0.14 мг', 'bar_percent' => 30, 'bar_variant' => 'min1'],
            ['section' => PlantNutritionItem::SECTION_MINERALS, 'label' => 'Йод', 'meta' => '6% нормы', 'value' => '9 мкг', 'bar_percent' => 18, 'bar_variant' => 'min2'],
            // antioxidants
            ['section' => PlantNutritionItem::SECTION_ANTIOXIDANTS, 'label' => 'Глюкозинолаты', 'meta' => 'противораковый эффект', 'value' => 'высокое', 'bar_percent' => 88, 'bar_variant' => 'ox1'],
            ['section' => PlantNutritionItem::SECTION_ANTIOXIDANTS, 'label' => 'Флавоноиды', 'meta' => 'сердечно-сосудистая защита', 'value' => 'высокое', 'bar_percent' => 78, 'bar_variant' => 'ox2'],
            ['section' => PlantNutritionItem::SECTION_ANTIOXIDANTS, 'label' => 'Полифенолы', 'meta' => 'замедляют старение', 'value' => 'высокое', 'bar_percent' => 72, 'bar_variant' => 'ox3'],
            ['section' => PlantNutritionItem::SECTION_ANTIOXIDANTS, 'label' => 'Антиоксидантный индекс (ORAC)', 'meta' => 'мкмоль TE/100г', 'value' => '1904', 'bar_percent' => 65, 'bar_variant' => 'ox4'],
        ];

        $order = 0;
        foreach ($rows as $r) {
            PlantNutritionItem::query()->create([
                'plant_id' => $plant->id,
                'section' => $r['section'],
                'label' => $r['label'],
                'meta' => $r['meta'],
                'value' => $r['value'],
                'bar_percent' => $r['bar_percent'],
                'bar_variant' => $r['bar_variant'],
                'sort_order' => $order++,
            ]);
        }
    }

    /**
     * @return Collection<int, Recipe>
     */
    private function seedRecipes()
    {
        $cta = url('/').'#catalog';

        $defs = [
            [
                'title' => 'Пицца бьянка с рукколой и прошутто',
                'slug' => 'pizza-bianka-rukola-proshutto',
                'image_url' => '/images/test-card/recipe-pizza.jpg',
                'time_label' => '25 мин',
                'calories_label' => '420 ккал',
                'difficulty_label' => 'Средне',
                'tag_top' => 'Горячее',
                'tag_bottom' => 'Горячее',
                'body' => 'Белая пицца из тонкого теста с рикоттой, моцареллой и розмарином.
                            Сразу после духовки — горсть свежей рукколы FITAHATA и тончайшие ломтики прошутто.',
                'ingredients' => [
                    'Руккола FITAHATA — 40 г',
                    'Тонкое тесто для пиццы',
                    'Рикотта — 100 г',
                    'Моцарелла — 80 г',
                    'Прошутто — 60 г',
                    'Чеснок — 2 зубчика',
                    'Оливковое масло, розмарин',
                ],
                'cta_label' => 'Купить рукколу',
                'cta_url' => $cta,
                'sort_order' => 0,
            ],
            [
                'title' => 'Салат с рукколой, грушей и пармезаном',
                'slug' => 'salat-rukola-grusha-parmezan',
                'image_url' => '/images/test-card/recipe-pizza.jpg',
                'time_label' => '15 мин',
                'calories_label' => '280 ккал',
                'difficulty_label' => 'Легко',
                'tag_top' => 'Салаты',
                'tag_bottom' => 'Салаты',
                'body' => 'Сочетание сладкой груши, солёного пармезана и пряной рукколы — быстрый обед или гарнир к ужину.',
                'ingredients' => [
                    'Руккола FITAHATA — 60 г',
                    'Груша — 1 шт.',
                    'Пармезан — 40 г',
                    'Грецкие орехи — 30 г',
                    'Бальзамический уксус, оливковое масло',
                ],
                'cta_label' => 'Купить рукколу',
                'cta_url' => $cta,
                'sort_order' => 1,
            ],
            [
                'title' => 'Паста с рукколой и вялеными томатами',
                'slug' => 'pasta-rukola-tomaty',
                'image_url' => '/images/test-card/recipe-pizza.jpg',
                'time_label' => '20 мин',
                'calories_label' => '380 ккал',
                'difficulty_label' => 'Средне',
                'tag_top' => 'Паста',
                'tag_bottom' => 'Паста',
                'body' => 'Спагетти с чесноком, оливковым маслом и вялеными томатами; руккола добавляется в тарелку свежей.',
                'ingredients' => [
                    'Руккола FITAHATA — 50 г',
                    'Спагетти — 200 г',
                    'Вяленые томаты — 80 г',
                    'Чеснок, каперсы',
                    'Оливковое масло',
                ],
                'cta_label' => 'Купить рукколу',
                'cta_url' => $cta,
                'sort_order' => 2,
            ],
            [
                'title' => 'Тартинки с авокадо и рукколой',
                'slug' => 'tartinki-avokado-rukola',
                'image_url' => '/images/test-card/recipe-pizza.jpg',
                'time_label' => '12 мин',
                'calories_label' => '240 ккал',
                'difficulty_label' => 'Легко',
                'tag_top' => 'Завтрак',
                'tag_bottom' => 'Завтрак',
                'body' => 'Хрустящий хлеб, паста из авокадо с лаймом и щедрый слой микрозелени рукколы сверху.',
                'ingredients' => [
                    'Руккола FITAHATA — 30 г',
                    'Авокадо — 1 шт.',
                    'Хлеб цельнозерновой — 4 ломтика',
                    'Лайм, соль, перец',
                ],
                'cta_label' => 'Купить рукколу',
                'cta_url' => $cta,
                'sort_order' => 3,
            ],
        ];

        return collect($defs)->map(function (array $d) {
            return Recipe::query()->updateOrCreate(
                ['slug' => $d['slug']],
                [
                    'title' => $d['title'],
                    'image_url' => $d['image_url'],
                    'time_label' => $d['time_label'],
                    'calories_label' => $d['calories_label'],
                    'difficulty_label' => $d['difficulty_label'],
                    'tag_top' => $d['tag_top'],
                    'tag_bottom' => $d['tag_bottom'],
                    'excerpt' => null,
                    'body' => $d['body'],
                    'ingredients' => $d['ingredients'],
                    'cta_label' => $d['cta_label'],
                    'cta_url' => $d['cta_url'],
                    'sort_order' => $d['sort_order'],
                ]
            );
        });
    }
}
