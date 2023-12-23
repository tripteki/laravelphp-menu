<?php

namespace App\Http\Controllers\Admin\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository;
use App\Imports\Menus\MenuImport;
use App\Exports\Menus\MenuExport;
use App\Http\Requests\Admin\Menus\MenuShowValidation;
use App\Http\Requests\Admin\Menus\MenuStoreValidation;
use App\Http\Requests\Admin\Menus\MenuUpdateValidation;
use App\Http\Requests\Admin\Menus\MenuDestroyValidation;
use App\Http\Requests\Admin\Menus\MenuActivationValidation;
use App\Http\Requests\Admin\Menus\MenuDeactivationValidation;
use Tripteki\Helpers\Http\Requests\FileImportValidation;
use Tripteki\Helpers\Http\Requests\FileExportValidation;
use Tripteki\Helpers\Http\Controllers\Controller;

class MenuAdminController extends Controller
{
    /**
     * @var \Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository
     */
    protected $menuAdminRepository;

    /**
     * @param \Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository $menuAdminRepository
     * @return void
     */
    public function __construct(IMenuAdminRepository $menuAdminRepository)
    {
        $this->menuAdminRepository = $menuAdminRepository;
    }

    /**
     * @OA\Get(
     *      path="/admin/menus",
     *      tags={"Admin Menu"},
     *      summary="Index",
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="limit",
     *          description="Menu's Pagination Limit."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="current_page",
     *          description="Menu's Pagination Current Page."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="order",
     *          description="Menu's Pagination Order."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="filter[]",
     *          description="Menu's Pagination Filter."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = [];
        $statecode = 200;

        $data = $this->menuAdminRepository->all();

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Get(
     *      path="/admin/menus/{identifier}",
     *      tags={"Admin Menu"},
     *      summary="Show",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="identifier",
     *          description="Menu's Identifier."
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
     * @param \App\Http\Requests\Admin\Menus\MenuShowValidation $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MenuShowValidation $request, $identifier)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        $data = $this->menuAdminRepository->get($identifier);

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Post(
     *      path="/admin/menus",
     *      tags={"Admin Menu"},
     *      summary="Store",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="platform",
     *                      type="string",
     *                      description="Menu's Platform."
     *                  ),
     *                  @OA\Property(
     *                      property="route",
     *                      type="string",
     *                      description="Menu's Route."
     *                  ),
     *                  @OA\Property(
     *                      property="nth",
     *                      type="integer",
     *                      description="Menu's Position."
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Menu's Title."
     *                  ),
     *                  @OA\Property(
     *                      property="metadata",
     *                      type="string",
     *                      description="Menu's Metadata."
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Menu's Description."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Menus\MenuStoreValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuStoreValidation $request)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->create($form);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Put(
     *      path="/admin/menus/{identifier}",
     *      tags={"Admin Menu"},
     *      summary="Update",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="identifier",
     *          description="Menu's Identifier."
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="platform",
     *                      type="string",
     *                      description="Menu's Platform."
     *                  ),
     *                  @OA\Property(
     *                      property="route",
     *                      type="string",
     *                      description="Menu's Route."
     *                  ),
     *                  @OA\Property(
     *                      property="nth",
     *                      type="integer",
     *                      description="Menu's Position."
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Menu's Title."
     *                  ),
     *                  @OA\Property(
     *                      property="metadata",
     *                      type="string",
     *                      description="Menu's Metadata."
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Menu's Description."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Menus\MenuUpdateValidation $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MenuUpdateValidation $request, $identifier)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->update($identifier, $form);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Delete(
     *      path="/admin/menus/{identifier}",
     *      tags={"Admin Menu"},
     *      summary="Destroy",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="identifier",
     *          description="Menu's Identifier."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Menus\MenuDestroyValidation $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MenuDestroyValidation $request, $identifier)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->delete($identifier);

        if ($data) {

            $statecode = 200;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Put(
     *      path="/admin/menus/activate/{identifier}",
     *      tags={"Admin Menu"},
     *      summary="Activate",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="identifier",
     *          description="Menu's Identifier."
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Menus\MenuActivationValidation $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(MenuActivationValidation $request, $identifier)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->activate($identifier);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Put(
     *      path="/admin/menus/deactivate/{identifier}",
     *      tags={"Admin Menu"},
     *      summary="Deactivate",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="identifier",
     *          description="Menu's Identifier."
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Menus\MenuDeactivationValidation $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(MenuDeactivationValidation $request, $identifier)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->deactivate($identifier);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Post(
     *      path="/admin/menus-import",
     *      tags={"Admin Menu"},
     *      summary="Import",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="file",
     *                      type="file",
     *                      description="Menu's File."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      )
     * )
     *
     * @param \Tripteki\Helpers\Http\Requests\FileImportValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(FileImportValidation $request)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        if ($form["file"]->getClientOriginalExtension() == "csv" || $form["file"]->getClientOriginalExtension() == "txt") {

            $data = Excel::import(new MenuImport(), $form["file"], null, \Maatwebsite\Excel\Excel::CSV);

        } else if ($form["file"]->getClientOriginalExtension() == "xls") {

            $data = Excel::import(new MenuImport(), $form["file"], null, \Maatwebsite\Excel\Excel::XLS);

        } else if ($form["file"]->getClientOriginalExtension() == "xlsx") {

            $data = Excel::import(new MenuImport(), $form["file"], null, \Maatwebsite\Excel\Excel::XLSX);
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Get(
     *      path="/admin/menus-export",
     *      tags={"Admin Menu"},
     *      summary="Export",
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="file",
     *          schema={"type": "string", "enum": {"csv", "xls", "xlsx"}},
     *          description="Menu's File."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      )
     * )
     *
     * @param \Tripteki\Helpers\Http\Requests\FileExportValidation $request
     * @return mixed
     */
    public function export(FileExportValidation $request)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        if ($form["file"] == "csv") {

            $data = Excel::download(new MenuExport(), "Menu.csv", \Maatwebsite\Excel\Excel::CSV);

        } else if ($form["file"] == "xls") {

            $data = Excel::download(new MenuExport(), "Menu.xls", \Maatwebsite\Excel\Excel::XLS);

        } else if ($form["file"] == "xlsx") {

            $data = Excel::download(new MenuExport(), "Menu.xlsx", \Maatwebsite\Excel\Excel::XLSX);
        }

        return $data;
    }
};
