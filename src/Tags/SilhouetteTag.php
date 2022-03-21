<?php

namespace Pattern\Silhouette\Tags;

use Statamic\Tags\Tags;

class SilhouetteTag extends Tags
{
    protected static $handle = 'silhouette';

    protected $attributes = 'name,email,avatar,initials';

    public function index()
    {
        $attributes = $this->params->get('attributes') ?? $this->attributes;
        $open = '<div
            x-data="{ silhouetteLoaded: false, silhouette: {} }"
            x-init="
                $watch(\'silhouette\', val => $dispatch(\'silhouette\', val));
                $nextTick(() => {
                    fetch(\'/!/silhouette/user?attributes=' . $attributes . '\')
                    .then(response => response.json())
                    .then(json => { silhouette = json; silhouetteLoaded = true; })
                })
            "
        >';
        $close = '</div>';

        return $open . $this->content . $close;
    }

    public function auth()
    {
        return "<template x-if='silhouetteLoaded && silhouette' x-cloak>{$this->content}</template>";
    }

    public function guest()
    {
        return "<template x-if='silhouetteLoaded && !silhouette' x-cloak>{$this->content}</template>";
    }

    public function wildcard($tag)
    {
        return "<span x-text='silhouette.{$tag}'></span>";
    }
}
