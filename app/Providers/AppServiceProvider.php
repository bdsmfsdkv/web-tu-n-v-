<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

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
        // Register ConfigHelper alias
        $this->app->bind('config-helper', function () {
            return new \App\Helpers\ConfigHelper();
        });

        // Force HTTPS in production or if needed
        if (config('app.env') === 'production' || (app()->bound('request') && request()->secure())) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        //
        Paginator::defaultView('vendor.pagination.default');

        Builder::macro('adminFilter', function ($request) {
            $query = $this;
            $table = $query->getModel()->getTable();
            $columns = Schema::getColumnListing($table);

            if ($request->filled('search')) {
                $search = $request->search;
                $searchFields = array_intersect($columns, ['id', 'name', 'title', 'username', 'email', 'code', 'transaction_id']);
                
                if (!empty($searchFields)) {
                    $query->where(function($q) use ($search, $searchFields) {
                        foreach ($searchFields as $field) {
                            $q->orWhere($field, 'like', "%{$search}%");
                        }
                    });
                }
            }

            if ($request->filled('start_date')) {
                $query->whereDate($table . '.created_at', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate($table . '.created_at', '<=', $request->end_date);
            }

            return $query;
        });

    }
}
