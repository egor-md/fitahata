<?php

use App\Models\Article;
use App\Models\ArticleBlock;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * 20 популярных культур микрозелени (без гречки).
     */
    private array $items = [
        ['name' => 'Руккола', 'slug' => 'rukola', 'price' => 'от 5,50 BYN', 'taste' => 'Пряный, с легкой горчинкой', 'benefit' => 'Богата витамином К и кальцием', 'badge' => 'Хит', 'image' => '/images/catalog/rukola.png'],
        ['name' => 'Горох', 'slug' => 'goroh', 'price' => 'от 4,90 BYN', 'taste' => 'Нежный, сладковатый', 'benefit' => 'Высокое содержание растительного белка', 'badge' => null, 'image' => '/images/catalog/gorokh.png'],
        ['name' => 'Редис', 'slug' => 'redis', 'price' => 'от 5,20 BYN', 'taste' => 'Острый, освежающий', 'benefit' => 'Витамины C и B, антиоксиданты', 'badge' => null, 'image' => '/images/catalog/redis.png'],
        ['name' => 'Подсолнечник', 'slug' => 'podsolnechnik', 'price' => 'от 4,50 BYN', 'taste' => 'Мягкий, ореховый', 'benefit' => 'Богат витамином E и цинком', 'badge' => 'Популярное', 'image' => '/images/catalog/podsolnechnik.png'],
        ['name' => 'Базилик', 'slug' => 'bazilik', 'price' => 'от 6,20 BYN', 'taste' => 'Пряный, ароматный', 'benefit' => 'Эфирные масла и антибактериальные свойства', 'badge' => 'Новинка', 'image' => '/images/catalog/bazilik.png'],
        ['name' => 'Брокколи', 'slug' => 'brokkoli', 'price' => 'от 5,80 BYN', 'taste' => 'Легкий, нейтральный', 'benefit' => 'Сульфорафан - мощный антиоксидант', 'badge' => null, 'image' => '/images/catalog/brokkoli.png'],
        ['name' => 'Пшеница', 'slug' => 'pshenica', 'price' => 'от 4,20 BYN', 'taste' => 'Сладковатый, травяной', 'benefit' => 'Хлорофилл и мягкий детокс-эффект', 'badge' => null, 'image' => '/images/catalog/pshenica.png'],
        ['name' => 'Кресс-салат', 'slug' => 'kress-salat', 'price' => 'от 4,80 BYN', 'taste' => 'Пикантный, немного перечный', 'benefit' => 'Поддержка иммунитета и обмена веществ', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,cress'],
        ['name' => 'Мизуна', 'slug' => 'mizuna', 'price' => 'от 6,10 BYN', 'taste' => 'Нежный, горчичный', 'benefit' => 'Кальций, железо и клетчатка', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,mizuna'],
        ['name' => 'Амарант', 'slug' => 'amarant', 'price' => 'от 6,40 BYN', 'taste' => 'Мягкий, слегка свекольный', 'benefit' => 'Антоцианы и микроэлементы', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,amaranth'],
        ['name' => 'Капуста краснокочанная', 'slug' => 'kapusta-krasnokochannaya', 'price' => 'от 5,90 BYN', 'taste' => 'Сочный, капустный', 'benefit' => 'Витамины C, K и антиоксиданты', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,red-cabbage'],
        ['name' => 'Кольраби', 'slug' => 'kolrabi', 'price' => 'от 5,70 BYN', 'taste' => 'Сладковатый, капустный', 'benefit' => 'Поддержка пищеварения, витамин C', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,kohlrabi'],
        ['name' => 'Дайкон', 'slug' => 'daikon', 'price' => 'от 5,30 BYN', 'taste' => 'Острый и свежий', 'benefit' => 'Ферменты для пищеварения', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,daikon'],
        ['name' => 'Кинза', 'slug' => 'kinza', 'price' => 'от 6,00 BYN', 'taste' => 'Яркий пряный аромат', 'benefit' => 'Эфирные масла и антиоксиданты', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,cilantro'],
        ['name' => 'Укроп', 'slug' => 'ukrop', 'price' => 'от 4,70 BYN', 'taste' => 'Свежий, укропный', 'benefit' => 'Витамин C и поддержка пищеварения', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,dill'],
        ['name' => 'Шпинат', 'slug' => 'shpinat', 'price' => 'от 5,60 BYN', 'taste' => 'Нежный, травяной', 'benefit' => 'Железо, фолаты и витамины группы B', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,spinach'],
        ['name' => 'Горчица', 'slug' => 'gorchica', 'price' => 'от 5,10 BYN', 'taste' => 'Острый, согревающий', 'benefit' => 'Фитонутриенты и витамин K', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,mustard'],
        ['name' => 'Свекла', 'slug' => 'svekla', 'price' => 'от 5,40 BYN', 'taste' => 'Сладковатый, землистый', 'benefit' => 'Бетаин и поддержка сосудов', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,beet'],
        ['name' => 'Лук шнитт', 'slug' => 'luk-shnitt', 'price' => 'от 4,90 BYN', 'taste' => 'Мягкий луковый вкус', 'benefit' => 'Сера и витамин C', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,chives'],
        ['name' => 'Пак-чой', 'slug' => 'pak-choj', 'price' => 'от 5,80 BYN', 'taste' => 'Сочный, мягко-пряный', 'benefit' => 'Кальций, калий и клетчатка', 'badge' => null, 'image' => 'https://source.unsplash.com/900x700/?microgreens,bok-choy'],
    ];

    public function up(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'microzelen'],
            ['name' => 'Микрозелень', 'show_in_menu' => true, 'sort_order' => 10]
        );

        // Чистим ранее добавленную гречку, если была в каталоге.
        $grechka = Article::where('category_id', $category->id)
            ->where('slug', 'grechka')
            ->first();
        if ($grechka) {
            $grechka->delete();
        }

        foreach ($this->items as $item) {
            $article = Article::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category->id,
                    'title' => $item['name'],
                    'is_visible' => true,
                    'is_main_for_category' => false,
                    'cover_path' => $item['image'],
                ]
            );

            $article->articleBlocks()->delete();

            ArticleBlock::create([
                'article_id' => $article->id,
                'position' => 0,
                'type' => 'main_info',
                'content' => [
                    'imageUrl' => $item['image'],
                    'imageAlt' => $item['name'],
                    'productName' => $item['name'],
                    'price' => $item['price'],
                    'benefit' => $item['benefit'],
                    'taste' => $item['taste'],
                    'description' => $this->descriptionFor($item['name'], $item['taste'], $item['benefit']),
                    'badge' => $item['badge'],
                ],
            ]);

            ArticleBlock::create([
                'article_id' => $article->id,
                'position' => 1,
                'type' => 'text',
                'content' => [
                    'body' => $this->articleTextFor($item['name']),
                ],
            ]);
        }
    }

    public function down(): void
    {
        $slugs = array_map(fn ($item) => $item['slug'], $this->items);
        Article::whereIn('slug', $slugs)->delete();
    }

    private function descriptionFor(string $name, string $taste, string $benefit): string
    {
        return $name.' — свежая микрозелень для салатов, боулов, сэндвичей и горячих блюд. '
            .'Вкус: '.$taste.'. Польза: '.$benefit.'. '
            .'Срезаем под заказ и доставляем максимально свежей.';
    }

    private function articleTextFor(string $name): string
    {
        return 'Как использовать '.$name.":\n"
            ."- добавляйте в салаты и сэндвичи;\n"
            ."- используйте как финиш для супов и горячих блюд;\n"
            ."- сочетайте с мягкими соусами и цитрусовыми заправками.\n\n"
            .'Совет по хранению: держите в холодильнике при +2..+6 C в закрытом контейнере, '
            .'лучше употребить в течение 3-5 дней.';
    }
};
