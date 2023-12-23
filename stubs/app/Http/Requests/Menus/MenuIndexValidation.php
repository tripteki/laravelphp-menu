<?php

namespace App\Http\Requests\Menus;

use Tripteki\Helpers\Http\Requests\FormValidation;

class MenuIndexValidation extends FormValidation
{
    /**
     * @return void
     */
    protected function preValidation()
    {
        return [

            "platform" => $this->route("platform"),
            "route" => $this->route("route"),
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            "platform" => "required|string",
            "route" => "required|string",
        ];
    }
};
