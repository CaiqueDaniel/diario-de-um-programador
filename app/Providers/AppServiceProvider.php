<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $urlGenerator)
    {
        $this->registerDirectives();

        if (env('APP_ENV') == 'production')
            $urlGenerator->forceScheme('https');
    }

    private function registerDirectives()
    {
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });

        Blade::directive('firstchar', fn(string $expression) => "<?php echo mb_substr({$expression}, 0, 1); ?>");
    }
}
