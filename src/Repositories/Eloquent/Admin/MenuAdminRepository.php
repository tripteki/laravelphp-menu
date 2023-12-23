<?php

namespace Tripteki\Menu\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Tripteki\Menu\Models\Menu;
use Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository;
use Tripteki\RequestResponseQuery\QueryBuilder;

class MenuAdminRepository implements IMenuAdminRepository
{
    /**
     * @param array $querystring|[]
     * @return mixed
     */
    public function all($querystring = [])
    {
        $querystringed =
        [
            "limit" => $querystring["limit"] ?? request()->query("limit", 10),
            "current_page" => $querystring["current_page"] ?? request()->query("current_page", 1),
        ];
        extract($querystringed);

        $content = QueryBuilder::for(Menu::class)->
        withTrashed()->
        defaultSort("nth")->
        allowedSorts([ "platform", "route", "nth", "title", ])->
        allowedFilters([ "platform", "route", "nth", "title", ])->
        paginate($limit, [ "*", ], "current_page", $current_page)->appends(empty($querystring) ? request()->query() : $querystringed);

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $querystring|[]
     * @return mixed
     */
    public function get($identifier, $querystring = [])
    {
        $content = Menu::findOrFail($identifier);

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function update($identifier, $data)
    {
        $content = Menu::findOrFail($identifier);

        DB::beginTransaction();

        try {

            $content->update($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        $content = null;

        DB::beginTransaction();

        try {

            $content = Menu::create($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $identifier
     * @return mixed
     */
    public function delete($identifier)
    {
        $content = Menu::findOrFail($identifier);

        DB::beginTransaction();

        try {

            $content->forceDelete();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $identifier
     * @return mixed
     */
    public function activate($identifier)
    {
        $content = Menu::withTrashed()->findOrFail($identifier);

        DB::beginTransaction();

        try {

            $content->activate();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $identifier
     * @return mixed
     */
    public function deactivate($identifier)
    {
        $content = Menu::findOrFail($identifier);

        DB::beginTransaction();

        try {

            $content->deactivate();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }
};
