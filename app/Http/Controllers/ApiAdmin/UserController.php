<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Repositories\Users\UserRepository;
use App\Http\Controllers\Controller;
use DB;

class UserController extends ApiController
{
    protected $validationRules
        = [
            'user_name'             => 'required',
            'email'    	            => 'required|email|unique:users,email',
            'password'              => 'required|min:6|max:255',
            'password_confirmation' => 'required|min:6|max:255|same:password',
        ];
    protected $validationMessages
        = [
            'user_name.required'                 => 'Tên không được để trông',
            'email.required'                     => 'Email không được để trông',
            'email.email'                        => 'Email không đúng định dạng',
            'email.unique'                       => 'Email đã tồn tại trên hệ thống',
            'password.required'                  => 'Mật khẩu không được để trống',
            'password.min'                       => 'Mật khẩu phải có ít nhât :min ký tự',
            'password.confirmed'                 => 'Nhập lại mật khẩu không đúng',
            'password_confirmation.required'     => 'Vui lòng nhập mật khẩu',
            'password_confirmation.min'          => 'Mật khẩu cần lớn hơn :min kí tự',
            'password_confirmation.max'          => 'Mật khẩu cần nhỏ hơn :max kí tự',
            'password_confirmation.same'         => 'Mật khẩu không khớp nhau',
        ];

    /**
     * CategoryController constructor.
     *
     * @param DistrictRepository $category
     */
	public function __construct(UserRepository $user)
	{
		$this->model = $user;
        $this->setTransformer(new UserTransformer);
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
            // return $request->all();
            $data = $this->model->storeUser($request->all());
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
            //$this->validationRules['name']       .= ",{$id}";

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
     * Cập nhật riêng lẻ các thuộc tính của category
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function minorUserUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        DB::enableQueryLog();
        try {
            $avaiable_option = [
                'status',
            ];
            $option = $request->get('option');

            if (!in_array($option, $avaiable_option)) {
                throw new \Exception('Không có quyền sửa đổi mục này');
            }

            $validate = array_only($this->validationRules, [
                $option,
            ]);

            $this->validate($request, $validate, $this->validationMessages);
            $data = $this->model->minorCategoryUpdate($id, $request->only($option));
            
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
}
