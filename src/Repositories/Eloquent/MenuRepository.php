<?php

namespace Tripteki\Menu\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Tripteki\Menu\Models\Menu;
use Tripteki\Menu\Contracts\Repository\IMenuRepository;
use Tripteki\RequestResponseQuery\QueryBuilder;

class MenuRepository implements IMenuRepository
{
    /**
     * @param string $platform
     * @param string $route
     * @param array $querystring|[]
     * @return mixed
     */
    public function all($platform, $route, $querystring = [])
    {
        $content = QueryBuilder::for(Menu::class)->
        where("platform", $platform)->
        where("route", $route)->
        defaultSort("nth")->
        allowedSorts([ "platform", "route", "nth", "title", ])->
        allowedFilters([ "platform", "route", "nth", "title", ])->
        get();

        return $content;
    }

    /**
     * @param string $platform
     * @param string $route
     * @param string $id
     * @param array $querystring|[]
     * @return mixed
     */
    public function get($platform, $route, $id, $querystring = [])
    {
        $content = Menu::where("platform", $platform)->where("route", $route)->findOrFail($id);

        return $content;
    }
};
