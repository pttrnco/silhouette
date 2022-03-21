<?php

namespace Pattern\Silhouette;

use Pattern\Silhouette\Tags\SilhouetteTag;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'actions' => __DIR__ . '/../routes/actions.php',
    ];

    protected $tags = [
        SilhouetteTag::class,
    ];

    public function boot()
    {
        parent::boot();
    }
}
