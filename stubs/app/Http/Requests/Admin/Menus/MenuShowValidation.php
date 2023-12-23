<?php

namespace App\Http\Requests\Admin\Menus;

use Tripteki\Menu\Models\Menu;
use Tripteki\Helpers\Http\Requests\FormValidation;

class MenuShowValidation extends FormValidation
{
    /**
     * @return void
     */
    protected function preValidation()
    {
        return [

            "id" => $this->route("menu"),
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

            "id" => "required|string|exists:".Menu::class,
        ];
    }
};
