<?php

namespace Pattern\Silhouette\Tags;

use Statamic\Tags\Tags;

class SilhouetteTag extends Tags
{
    protected static $handle = 'silhouette';

    public function index()
    {
        $attributes = $this->params->get('attributes') ?? 'name,email,avatar,initials';
        $openingTag = '<div
            x-data="{
                silhouetteLoaded: false,
                silhouette: {}
            }"
            x-init="
                $watch(\'silhouette\', val => {
                    $dispatch(\'silhouette\', val);}
                );
                $nextTick(() => {
                    fetch(\'/!/silhouette/user?attributes=' . $attributes . '\')
                    .then(response => response.json())
                    .then(json => {
                        setTimeout(() => silhouette = json, 50);
                        silhouetteLoaded = true;
                    })
                })
            "
        >';
        $closingTag = '</div>';

        return $openingTag . $this->content . $closingTag;
    }

    public function auth()
    {
        $openingTag = '<template x-if="silhouetteLoaded && silhouette">';
        $closingTag = '</template>';

        return $openingTag . $this->content . $closingTag;
    }

    public function guest()
    {
        $openingTag = '<template x-if="silhouetteLoaded && !silhouette">';
        $closingTag = '</template>';

        return $openingTag . $this->content . $closingTag;
    }

    public function wildcard($tag)
    {
        return '<span x-text="silhouette.' . $tag . '"></span>';
    }
}
