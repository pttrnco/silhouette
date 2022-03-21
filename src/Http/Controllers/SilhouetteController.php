<?php

namespace Pattern\Silhouette\Http\Controllers;

use Statamic\Http\Controllers\Controller;

class SilhouetteController extends Controller
{
    public function __invoke()
    {
        if (auth()->check()) {
            return response()
                ->json(
                    collect(
                        explode(',', request('attributes'))
                    )->flatMap(function ($attribute) {
                        $isMethod = false;
                        if (substr($attribute, -2) == '()') {
                            $attribute = substr($attribute, 0, -2);
                            $isMethod = true;
                        }
                        if ($attribute != 'password') {
                            return [
                                $attribute => $this->getAttribute($attribute, $isMethod)
                            ];
                        }
                    })
                );
        }

        return response()->json(false);
    }

    private function getAttribute($attribute, $isMethod)
    {
        if ($isMethod) {
            return auth()->user()->{$attribute}();
        }
        return auth()->user()->{$attribute};
    }
}
