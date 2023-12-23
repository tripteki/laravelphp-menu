<?php

namespace App\Http\Requests\Menus;

use Illuminate\Validation\Rule;
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

            "platform" => $this->route("platform"),
            "route" => $this->route("route"),
            "id" => $this->route("id"),
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
            "id" => Rule::exists(Menu::class)->where(function ($query) {

                return $query->where("platform", $this->route("platform"))->where("route", $this->route("route"));
            }),
        ];
    }
};
