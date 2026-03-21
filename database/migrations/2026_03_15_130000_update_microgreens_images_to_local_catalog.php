<?php

use App\Models\Article;
use App\Models\ArticleBlock;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $localBySlug = [
        'rukola' => '/images/catalog/rukola.png',
        'goroh' => '/images/catalog/goroh.png',
        'redis' => '/images/catalog/redis.png',
        'podsolnechnik' => '/images/catalog/podsolnechnik.png',
        'bazilik' => '/images/catalog/bazilik.png',
        'brokkoli' => '/images/catalog/brokkoli.png',
        'pshenica' => '/images/catalog/pshenica.png',
        'kress-salat' => '/images/catalog/kress-salat.png',
        'mizuna' => '/images/catalog/mizuna.png',
        'amarant' => '/images/catalog/amarant.png',
        'kapusta-krasnokochannaya' => '/images/catalog/kapusta-krasnokochannaya.png',
        'kolrabi' => '/images/catalog/kolrabi.png',
        'daikon' => '/images/catalog/daikon.png',
        'kinza' => '/images/catalog/kinza.png',
        'ukrop' => '/images/catalog/ukrop.png',
        'shpinat' => '/images/catalog/shpinat.png',
        'gorchica' => '/images/catalog/gorchica.png',
        'svekla' => '/images/catalog/svekla.png',
        'luk-shnitt' => '/images/catalog/luk-shnitt.png',
        'pak-choj' => '/images/catalog/pak-choj.png',
    ];

    public function up(): void
    {
        foreach ($this->localBySlug as $slug => $path) {
            $article = Article::where('slug', $slug)->first();
            if (! $article) {
                continue;
            }

            $article->cover_path = $path;
            $article->save();

            $mainInfo = ArticleBlock::where('article_id', $article->id)
                ->where('type', 'main_info')
                ->first();

            if (! $mainInfo) {
                continue;
            }

            $content = is_array($mainInfo->content) ? $mainInfo->content : [];
            $content['imageUrl'] = $path;
            if (empty($content['imageAlt'])) {
                $content['imageAlt'] = $article->title;
            }
            $mainInfo->content = $content;
            $mainInfo->save();
        }
    }

    public function down(): void
    {
        // intentionally left empty
    }
};
