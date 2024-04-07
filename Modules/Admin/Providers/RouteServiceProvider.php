<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Validator;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Admin\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //验证正整数
        Validator::extend('is_positive_integer', function ($attribute, $value, $parameters, $validator) {
            if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
                return true;
            } else {
                return false;
            }
        });
        //验证0和1的状态
        Validator::extend('is_status_integer', function ($attribute, $value, $parameters, $validator) {
            if (is_numeric($value) && is_int($value + 0) && in_array(($value + 0), [0, 1])) {
                return true;
            } else {
                return false;
            }
        });
        //验证是否为数组并且里面的值必须是正整数
        Validator::extend('is_array_integer', function ($attribute, $value, $parameters, $validator) {
            if (is_array($value) && count($value) > 0) {
                foreach ($value as $v) {
                    if (!is_numeric($v) || !is_int($v + 0) || ($v + 0) <= 0) {
                        return false;
                    }
                }
            } else {
                return false;
            }
            return true;
        });
        //验证pid整数
        Validator::extend('is_pid_integer', function ($attribute, $value, $parameters, $validator) {
            if (is_numeric($value) && is_int($value + 0) && ($value + 0) >= 0) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Admin', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Admin', '/Routes/api.php'));
    }
}
