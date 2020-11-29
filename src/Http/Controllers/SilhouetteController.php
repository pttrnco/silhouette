<?php

namespace Pattern\Silhouette\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Auth\Eloquent\User as StatamicUser;
use Statamic\Http\Controllers\Controller;

class SilhouetteController extends Controller
{
    protected $methods;
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user() && config('silhouette.model')
                ? StatamicUser::fromModel(auth()->user())
                : auth()->user();

            return $next($request);
        });

        $this->methods = [
            'email',
            'initials'
        ];
    }

    public function __invoke(Request $request)
    {
        if ($this->user) {
            return response()
                ->json(
                    collect(
                        explode(',', $request->input('attributes'))
                    )->flatMap(function ($attribute) {
                        if ($attribute != 'password') {
                            return [
                                $attribute => $this->getAttribute($attribute)
                            ];
                        }
                    })
                );
        }

        return response()->json(false);
    }

    private function getAttribute($attribute)
    {
        if (in_array($attribute, $this->methods)) {
            return $this->user->{$attribute}();
        }
        return $this->user->value($attribute);
    }
}
