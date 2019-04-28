<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Transformers\TagTransformer;
use Illuminate\Http\Request;
use App\Repositories\Tags\TagRepository;
use App\Http\Controllers\Controller;
use DB;

class TagController extends ApiController
{
    protected $validationRules
        = [
            'tag_name'       => 'required|v_title|unique:tags,tag_name',
            'hot'     => 'numeric|between:0,1',
        ];
    protected $validationMessages
        = [
            'tag_name.required'   => 'Vui lòng điền tên danh mục',
            'tag_name.v_title'    => 'Tên danh mục không hợp lệ',
            'tag_name.unique'     => 'Tên danh mục đã tồn tại',
            'hot.numeric'         => 'Phải là kiểu số',
            'hot.between'         => 'Khoảng từ 0 đến 1',
        ];

    /**
     * CategoryController constructor.
     *
     * @param DistrictRepository $category
     */
	public function __construct(TagRepository $tag)
	{
		$this->model = $tag;
        $this->setTransformer(new TagTransformer);
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
            // return $request->all();
            $data = $this->model->store($request->all());
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
        DB::beginTransaction();
        try {
            $this->validationRules['tag_name']       .= ",{$id}";

            $this->validate($request, $this->validationRules, $this->validationMessages);

            $data = $this->model->update($id, $request->all());
            DB::commit();
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
