<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Transformers\QuestionTransformer;
use Illuminate\Http\Request;
use App\Repositories\Questions\QuestionRepository;
use App\Repositories\Questions\Question;
use App\Http\Controllers\Controller;
use DB;

class QuestionController extends ApiController
{
    protected $validationRules
        = [
            'question'          => 'required|min:10|max:255|unique:questions,question',
            'user_id'           => 'required|integer|exists:users,id,deleted_at,NULL',
            'tag_id'            => 'required|integer|exists:tags,id,deleted_at,NULL',
        ];
    protected $validationMessages
        = [
            'question.required'      => 'Câu hỏi không được để trống',
            'question.min'           => 'Tối thiểu 10 ký tự',
            'question.max'           => 'Tối đa 255 ký tự',
            'question.unique'        => 'Câu hỏi này đã tồn tại',
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
	public function __construct(QuestionRepository $question)
	{
		$this->model = $question;
        $this->setTransformer(new QuestionTransformer);
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
            $this->validationRules['question']       .= ",{$id}";

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
