<?php

namespace App\Providers;

use Awssat\QueryReset\QueryReset;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class QueryResetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     * resetOrder()
     * resetLimit()
     * resetOffset()
     * resetHaving()
     * resetWhere()
     * resetSelect()
     * resetJoin()
     * resetDistinct()
     * resetGroup()
     * resetAggregate()
     */
    public function register()
    {
        //Query builder
        Collection::make(QueryReset::getMethods())
            ->reject(function($method) {
                return Builder::hasMacro('reset'. ucfirst($method));
            })
            ->each(function($method) {
                Builder::macro('reset'. ucfirst($method), QueryReset::$method());
            });
    }
}
