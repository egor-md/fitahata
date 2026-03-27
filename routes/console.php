<?php

use App\Support\ImageVariants;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('images:generate-variants {collection=catalog}', function (string $collection) {
    if ($collection === 'plants') {
        $collection = 'catalog';
    }

    $directory = public_path('images/'.$collection);

    if (! File::isDirectory($directory)) {
        $this->error('Directory not found: '.$directory);

        return self::FAILURE;
    }

    $files = collect(File::files($directory))
        ->filter(function (SplFileInfo $file): bool {
            if (ImageVariants::isVariantFilename($file->getFilename())) {
                return false;
            }

            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
        })
        ->sortByDesc(fn (SplFileInfo $file): int => strtolower($file->getExtension()) === 'webp' ? 1 : 0)
        ->values();

    $bar = $this->output->createProgressBar($files->count());
    $bar->start();

    foreach ($files as $file) {
        ImageVariants::generateSquareVariants($file->getPathname(), ImageVariants::CATALOG_SQUARE_SIZES);
        $bar->advance();
    }

    $bar->finish();
    $this->newLine(2);
    $this->info('Generated square image variants for '.$files->count().' files in '.$collection.'.');

    return self::SUCCESS;
})->purpose('Generate square webp image variants (160/300/640) for catalog images');

Artisan::command('catalog:materialize-demo-images {--force : Перезаписать существующие webp}', function () {
    $template = collect([
        public_path('images/test-card/phero3.jpg'),
        public_path('images/test-card/phero2.jpg'),
        public_path('images/test-card/phero1.jpg'),
    ])->first(fn (string $p): bool => is_file($p));

    if ($template === null) {
        $this->error('Нет шаблона: положите phero1.jpg…phero3.jpg в public/images/test-card/ или загрузите фото через админку.');

        return self::FAILURE;
    }

    $slugs = [
        'podsolnechnik', 'goroh', 'rediska', 'brokkoli', 'gorchitsa', 'svyokla',
        'kale', 'kinza', 'bazilik', 'amarant', 'mangold', 'shpinat', 'pshenitsa',
        'klever', 'kress', 'mizuna', 'fenkhel', 'luk', 'schavel', 'rukola',
        'placeholder',
    ];

    $mime = File::mimeType($template);
    $gd = match ($mime) {
        'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($template),
        'image/png' => @imagecreatefrompng($template),
        'image/webp' => @imagecreatefromwebp($template),
        default => null,
    };

    if (! $gd instanceof GdImage) {
        $this->error('Не удалось прочитать шаблон: '.$template);

        return self::FAILURE;
    }

    File::ensureDirectoryExists(public_path('images/catalog'));

    $force = (bool) $this->option('force');
    $created = 0;

    foreach ($slugs as $slug) {
        $dest = public_path('images/catalog/'.$slug.'.webp');
        if (is_file($dest) && ! $force) {
            continue;
        }

        if (! imagewebp($gd, $dest, 82)) {
            $this->warn('Не записан: '.$dest);

            continue;
        }

        ImageVariants::generateSquareVariants($dest, ImageVariants::CATALOG_SQUARE_SIZES);
        $created++;
    }

    imagedestroy($gd);

    $this->info('Готово: создано/обновлено файлов: '.$created.' (каталог public/images/catalog, варианты _160/_300/_640).');

    return self::SUCCESS;
})->purpose('Создать демо webp по культурам из test-card (для сидов /images/catalog/{slug}.webp)');
