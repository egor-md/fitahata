<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    @vite(['resources/css/site.css'])
    @stack('styles')
</head>
<body>
    <header class="site-header">
        <nav class="site-nav site-container">
            <div class="site-nav-left">
                <div class="menu">
                @foreach((is_iterable($menuCategories ?? null) ? $menuCategories : []) as $category)
                    @php
                        if (!($category instanceof \App\Models\Category)) {
                            continue;
                        }

                        $mainArticle = method_exists($category, 'relationLoaded') && $category->relationLoaded('mainArticle')
                            ? $category->mainArticle
                            : null;

                        $articles = $category->articles ?? collect();
                        $dropdownArticles = $mainArticle
                            ? $articles->where('id', '!=', $mainArticle->id)
                            : $articles;
                    @endphp

                    @if($mainArticle)
                        <div class="menu-item">
                            <a href="{{ route('article.show', $mainArticle->slug) }}" class="menu-link">
                                {{ $category->name }}
                            </a>
                            @if($dropdownArticles->isNotEmpty())
                                <div class="menu-dropdown">
                                    @foreach($dropdownArticles as $article)
                                        <a href="{{ route('article.show', $article->slug) }}" class="menu-dropdown-link">
                                            {{ $article->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @elseif($articles && $articles->isNotEmpty())
                        <div class="menu-item">
                            <button type="button" class="menu-button">
                                {{ $category->name }}
                                <svg class="menu-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>
                            <div class="menu-dropdown">
                                @foreach($articles as $article)
                                    <a href="{{ route('article.show', $article->slug) }}" class="menu-dropdown-link">
                                        {{ $article->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span class="menu-text">{{ $category->name }}</span>
                    @endif
                @endforeach
                </div>
            </div>

            <div class="site-nav-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="site-nav-link">
                        Админка
                    </a>
                @else
                    <a href="{{ route('login') }}" class="site-nav-link">
                        Вход
                    </a>
                    @if($canRegister ?? true)
                        <a href="{{ route('register') }}" class="site-nav-link">
                            Регистрация
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-container">
            Футер
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

