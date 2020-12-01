<?php

namespace Pattern\Silhouette;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'actions' => __DIR__ . '/../routes/actions.php',
    ];

    protected $tags = [
        \Pattern\Silhouette\Tags\SilhouetteTag::class,
    ];

    public function boot()
    {
        parent::boot();
    }
}
