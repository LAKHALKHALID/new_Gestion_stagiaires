<?php

namespace App\Providers;

use App\Models\Stagiaire;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();
        View::composer('layout.navBar', function ($view) {
            $annees = Stagiaire::withoutGlobalScope('selecte_by_nom_annee_scolaire')->distinct()->pluck('nom_annee_scolaire');
            $view->with('annees', $annees);
        });
    }
}
