<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tripteki\Menu\Contracts\Repository\IMenuRepository;
use App\Http\Requests\Menus\MenuIndexValidation;
use App\Http\Requests\Menus\MenuShowValidation;
use Tripteki\Helpers\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * @var \Tripteki\Menu\Contracts\Repository\IMenuRepository
     */
    protected $menuRepository;

    /**
     * @param \Tripteki\Menu\Contracts\Repository\IMenuRepository $menuRepository
     * @return void
     */
    public function __construct(IMenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @OA\Get(
     *      path="/menus/{platform}/routes/{route}/ids",
     *      tags={"Menus"},
     *      summary="Index",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="platform",
     *          description="Menu's Platform."
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="route",
     *          description="Menu's Route."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      )
     * )
     *
     * @param \App\Http\Requests\Menus\MenuIndexValidation $request
     * @param string $platform
     * @param string $route
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MenuIndexValidation $request, $platform, $route)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        $data = $this->menuRepository->all($platform, $route);

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Get(
     *      path="/menus/{platform}/routes/{route}/ids/{id}",
     *      tags={"Menus"},
     *      summary="Show",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="platform",
     *          description="Menu's Platform."
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="route",
     *          description="Menu's Route."
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="id",
     *          description="Menu's Id."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Menus\MenuShowValidation $request
     * @param string $platform
     * @param string $route
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MenuShowValidation $request, $platform, $route, $id)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        $data = $this->menuRepository->get($platform, $route, $id);

        return iresponse($data, $statecode);
    }
};
