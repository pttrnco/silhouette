<?php

namespace Pattern\Silhouette;

use Illuminate\Support\Facades\Route;
use Pattern\Silhouette\Http\Controllers\SilhouetteController;
use Pattern\Silhouette\Tags\SilhouetteTag;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        SilhouetteTag::class,
    ];

    public function boot()
    {
        parent::boot();

        Statamic::booted(function () {
            $this->registerActionRoutes(function () {
                Route::get('user', SilhouetteController::class);
            });
        });
    }
}
