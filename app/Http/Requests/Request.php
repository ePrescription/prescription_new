<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /*public function validator($factory)
    {
        return $factory->make(
            $this->sanitizeInput(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    protected function sanitizeInput()
    {
        if (method_exists($this, 'sanitize'))
        {
            return $this->container->call([$this, 'sanitize']);
        }

        return $this->all();
    }*/
}
