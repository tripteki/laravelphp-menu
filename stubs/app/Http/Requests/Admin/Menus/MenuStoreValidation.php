<?php

namespace App\Http\Requests\Admin\Menus;

use Illuminate\Validation\Rule;
use Tripteki\Menu\Models\Menu;
use Tripteki\Helpers\Http\Requests\FormValidation;

class MenuStoreValidation extends FormValidation
{
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

            "platform" => "required|string|lowercase|max:8",
            "route" => "required|string|max:127|regex:/^[0-9a-zA-Z\._\-\=\?]+$/",
            "nth" => "required|integer",
            "title" => [

                "required",
                "string",
                "lowercase",
                "max:32",
                "alpha_dash:ascii",
                Rule::unique(Menu::class)->where(function ($query) {

                    return $query->where("platform", $this->input("platform"))->where("route", $this->input("route"));
                }),
            ],
            "metadata" => "present|json|nullable",
            "description" => "present|string|max:255|nullable",
        ];
    }
};
