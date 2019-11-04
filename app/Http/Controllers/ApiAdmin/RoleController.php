<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Transformers\RoleTransformer;
use Illuminate\Http\Request;
use App\Repositories\Roles\RoleRepository;
use DB;

class RoleController extends ApiController
{
    protected $validationRules
        = [
            'name'        => 'required|unique:roles,name',
            'slug'        => 'required',
            'permissions' => 'nullable|array',
        ];
    protected $validationMessages
        = [
            'name.required'     => 'Tên không được để trông',
            'slug.required'     => 'Slug không được để trông',
            'permissions.array' => 'Danh sách quyền không đúng định dạng array',
        ];

    /**
     * CategoryController constructor.
     *
     * @param DistrictRepository $category
     */
	public function __construct(RoleRepository $category)
	{
		$this->model = $category;
        $this->setTransformer(new RoleTransformer);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	try {
            $pageSize    = $request->get('limit', 25);
            $data       = $this->model->getByQuery($request->all(), $pageSize, $this->trash);
    		return $this->successResponse($data);
    	} catch (Exception $e) {
    		throw $e;
    	}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) 
    {
        try {
            $trashed = $request->has('trashed') ? true : false;
            $data    = $this->model->getById($id, $trashed);
            return $this->successResponse($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, $this->validationRules, $this->validationMessages);
            $data = $this->model->storeRole($request->all());
            DB::commit();
            return $this->successResponse($data);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            DB::rollBack();
            return $this->errorResponse([
                'errors'    => $validationException->validator->errors(),
                'exception' => $validationException->getMessage(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (\Throwable $t) {
            DB::rollBack();
            throw $t;
        }
    }

    public function update(Request $request, $id)
    {
        //DB::beginTransaction();
        try {
            $validate = array_only($this->validationRules, [
                'permissions',
                'slug'
            ]);

            $this->validate($request, $validate, $this->validationMessages);
            $model = $this->model->updateRole($id, $request->all());

            return $this->successResponse($model);
            //DB::commit();
            return $this->successResponse($data);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            DB::rollBack();
            return $this->errorResponse([
                'errors'    => $validationException->validator->errors(),
                'exception' => $validationException->getMessage(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (\Throwable $t) {
            DB::rollBack();
            throw $t;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->delete($id);
            DB::commit();
            return $this->deleteResponse();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (\Throwable $t) {
            DB::rollBack();
            throw $t;
        }
    }
}
