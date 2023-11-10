<?php

namespace App\Http\Middleware;

// use Illuminate\Foundation\Http\Middleware\TransformsRequest as TransformsRequest;
use Closure;
use Symfony\Component\HttpFoundation\ParameterBag;

class SanitizationData
{
    public function handle($request, Closure $next)
    {
        if ($request->isJson()) {
            $this->clean($request->json());
        } else {
            $this->clean($request->request);
        }
        return $next($request);
    }

    public function clean(ParameterBag $bag)
    {
        $bag->replace($this->cleanData($bag->all()));
    }

    public function cleanData(array $data)
    {
        $data['playerskills'] = $data['playerSkills'];
        unset($data['playerSkills']);

        return collect($data)->map(function ($value, $key) {
            if ($key == 'playerSkills') {
                $key = 'playerskills';
                return $value;
            } else {
                return $value;
            }
        })->all();
    }
}
