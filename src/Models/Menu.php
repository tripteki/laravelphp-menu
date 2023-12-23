<?php

namespace Tripteki\Menu\Models;

use Tripteki\Uid\Traits\UniqueIdTrait;
use Tripteki\Menu\Providers\MenuServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Menu extends Model
{
    use UniqueIdTrait, SoftDeletes;

    /**
     * @var array
     */
    protected $casts = [

        "metadata" => "array",
    ];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function metadata(): Attribute
    {
        return Attribute::make(

            set: fn ($value) => json_encode(is_string($value) ? json_decode(stripslashes($value)) : $value),
            get: fn ($value) => array_map(fn ($metadata) => @pathinfo($metadata)["extension"] ? MenuServiceProvider::locate($metadata) : $metadata, json_decode($value, true)),
        );
    }

    /**
     * @return void
     */
    public function activate()
    {
        $this->restore();
    }

    /**
     * @return void
     */
    public function deactivate()
    {
        $this->delete();
    }
};
