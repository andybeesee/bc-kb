<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('paginator');

        Blade::directive('currency', function ($number) {
            return "<?php echo numfmt_format_currency(numfmt_create( 'en_US', \NumberFormatter::CURRENCY), (int) $number, 'USD'); ?>";
        });

        Blade::directive('number', function ($expression) {
            return "<?php echo number_format($expression); ?>";
        });

        Relation::morphMap([
            'board' => \App\Models\Board::class,
            'comment' => \App\Models\Comment::class,
            'discussion' => \App\Models\Discussion::class,
            'project' => \App\Models\Project::class,
            'task' => \App\Models\Task::class,
            'team' => \App\Models\Team::class,
            'user' => \App\Models\User::class,
        ]);
    }
}
