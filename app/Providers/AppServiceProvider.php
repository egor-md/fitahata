<?php

namespace App\Providers;

use App\Models\Category;
use Carbon\CarbonImmutable;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        View::composer('layouts.site', function ($view) {
            $view->with('menuCategories', Category::where('show_in_menu', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->with([
                    'articles' => fn ($q) => $q->where('is_visible', true)->orderBy('title'),
                    'mainArticle',
                ])
                ->get(['id', 'name', 'slug', 'sort_order']))
                ->with('canRegister', Features::enabled(Features::registration()));
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
