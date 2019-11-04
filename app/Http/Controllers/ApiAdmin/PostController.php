<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\Post;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class PostController extends ApiController
{
    protected $validationRules
        = [
            'description'       => 'required|min:10|max:255|unique:posts,description',
            'content'           => 'required',
            //'view_count'        => 'numeric',
            'status'            => 'integer|between:0,1',
            'hot'               => 'integer|between:0,1',
            'user_id'           => 'required|integer|exists:users,id,deleted_at,NULL',
            'tag_id'            => 'required|integer|exists:tags,id,deleted_at,NULL',
        ];
    protected $validationMessages
        = [
            'description.required'   => 'Mô tả không được để trống',
            'description.min'        => 'Tối thiểu 10 ký tự',
            'description.max'        => 'Tối đa 255 ký tự',
            'description.unique'     => 'Mô tả này đã tồn tại',
            'content.unique'         => 'Nội dung không được để trống',
            //'view_count.numeric'     => 'Phải là kiểu số',
            'status.integer'         => 'Phải là kiểu số',
            'status.between'         => 'Khoảng từ 0 đến 1',
            'hot.integer'            => 'Phải là kiểu số',
            'hot.between'            => 'Khoảng từ 0 đến 1',
            'user_id.required'       => 'Mã người dùng không được để trống',
            'user_id.integer'        => 'Mã người dùng phải là kiểu số',
            'user_id.exists'         => 'Mã người dùng không tồn tại',
            'tag_id.required'        => 'Mã tag không được để trống',
            'tag_id.integer'         => 'Mã tag phải là kiểu số',
            'tag_id.exists'          => 'Mã tag không tồn tại',
        ];

    /**
     * CategoryController constructor.
     *
     * @param DistrictRepository $category
     */
	public function __construct(PostRepository $post)
	{
		$this->model = $post;
        $this->setTransformer(new PostTransformer);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	try {
            //$this-> authorize('post.view');
            $pageSize    = $request->get('limit', 25);
            $data       = $this->model->getByQuery($request->all(), $pageSize, $this->trash);
    		return $this->successResponse($data);
    	} catch (Exception $e) {
    		throw $e;
    	} catch (AuthorizationException $f) {
            return $this->forbidden([
                'error' => $f->getMessage(),
            ]);
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
            //return $request->all();
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
            $this->validationRules['description']       .= ",{$id}";

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

    /**
     * Cập nhật riêng lẻ các thuộc tính của post
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function minorPostUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        DB::enableQueryLog();
        try {
            $avaiable_option = [
                'status', 'hot'
            ];
            $option = $request->get('option');

            if (!in_array($option, $avaiable_option)) {
                throw new \Exception('Không có quyền sửa đổi mục này');
            }

            $validate = array_only($this->validationRules, [
                $option,
            ]);

            $this->validate($request, $validate, $this->validationMessages);
            $data = $this->model->minorPostUpdate($id, $request->only($option));
            
            DB::commit();

            return $this->successResponse($data);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return $this->errorResponse([
                'errors'    => $validationException->validator->errors(),
                'exception' => $validationException->getMessage(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->notFoundResponse();
        } catch (\Exception $e) {
            return $this->errorResponse([
                'error' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Throwable $t) {
            DB::rollBack();
            throw $t;
        }
    }

    /**
     * Lấy ra các Trạng thái bài viết (theo status)
     * @author sonduc <ndson1998@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function statusList()
    {
        try {
            //$this->authorize('place.view');
            $data = $this->simpleArrayToObject(Post::POST_STATUS);
            return response()->json($data);
        } catch (AuthorizationException $f) {
            DB::rollBack();
            return $this->forbidden([
                'error' => $f->getMessage(),
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Lấy ra các nổi bật bài viết (theo hot)
     * @author sonduc <ndson1998@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function hotList()
    {
        try {
            //$this->authorize('place.view');
            $data = $this->simpleArrayToObject(Post::POST_HOT);
            return response()->json($data);
        } catch (AuthorizationException $f) {
            DB::rollBack();
            return $this->forbidden([
                'error' => $f->getMessage(),
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
