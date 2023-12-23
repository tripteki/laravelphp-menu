<?php

namespace App\Imports\Menus;

use Illuminate\Validation\Rule;
use Tripteki\Menu\Models\Menu;
use Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository;
use App\Http\Requests\Admin\Menus\MenuStoreValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class MenuImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param \Illuminate\Support\Collection $rows
     * @return void
     */
    protected function validate(Collection $rows)
    {
        $validator = (new MenuStoreValidation())->rules();

        $rows->map(function ($row) use ($validator, $rows) {

            Validator::make($rows->toArray(), [

                "*.0" => $validator["platform"],
                "*.1" => $validator["route"],
                "*.2" => $validator["nth"],
                "*.3" => [

                    "required",
                    "string",
                    "lowercase",
                    "max:32",
                    "alpha_dash:ascii",
                    Rule::unique(Menu::class, "title")->where(function ($query) use ($row) {

                        return $query->where("platform", $row[0])->where("route", $row[1]);
                    }),
                ],
                "*.4" => $validator["metadata"],
                "*.5" => $validator["description"],

            ])->validate();
        });
    }

    /**
     * @param \Illuminate\Support\Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $this->validate($rows);

        $menuAdminRepository = app(IMenuAdminRepository::class);

        foreach ($rows as $row) {

            $menuAdminRepository->create([

                "platform" => $row[0],
                "route" => $row[1],
                "nth" => $row[2],
                "title" => $row[3],
                "metadata" => $row[4],
                "description" => $row[5],
            ]);
        }
    }
};
