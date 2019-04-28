<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Response\ResponseHandler;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    use ResponseHandler, ValidatesRequests;
    
    const WITH_TRASH = 1; // lây tất cả các bản ghi cả cả bản ghi đã xóa
    const ONLY_TRASH = 2; // chi lây những bản ghi đã xóa
    const NO_TRASH   = 0; // lấy những bản ghi mà chưa bị xóa

    protected $model;
    protected $trash = self::NO_TRASH;

    /**
     * Kiểm tra xem request có include 'trashed'
     *
     * @param $request
     *
     * @return int
     */
    public function trashStatus($request): int
    {
        if ($request->has('trashed')) {
            return $request->get('trashed') === 'only' ? self::ONLY_TRASH : self::WITH_TRASH;
        }
        return self::NO_TRASH;
    }

    /**
     * Tạo mảng các object từ array
     *
     * @param array $arr
     *
     * @return array
     */
    protected function simpleArrayToObject($arr = []): array
    {
        $arr2d = [];
        foreach ($arr as $key => $item) {
            $arr2d[] = [
                'id'    => $key,
                'value' => $item,
            ];
        }

        return $arr2d;
    }
}
