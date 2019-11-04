<?php 

namespace App\Repositories;

use App\Repositories\Traits\Scope;

abstract class BaseRepository implements EntityInterface
{
    use Scope;
    // Các trạng thái của bản ghi đã bị softDeletes
    const WITH_TRASH = 1; // lây tất cả các bản ghi cả cả bản ghi đã xóa
    const ONLY_TRASH = 2; // chi lây những bản ghi đã xóa
    const NO_TRASH   = 0; // lấy những bản ghi mà chưa bị xóa

    /**
     * Eloquent model
     * @var Eloquent
     */
    protected $model;

    /**
     * Lấy tất cả bản ghi của model
     *
     * @return Illuminate\Support\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Lấy tất cả bản ghi có phân trang
     *
     * @param array $params
     * @param int   $size
     * @param int   $trash
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getByQuery($params = [], $size = 25, $trash = self::NO_TRASH)
    {
        $sort           = array_get($params, 'sort', 'created_at:-1');
        $params['sort'] = $sort;
        $this->useScope($params);

        switch ($trash) {
            case self::WITH_TRASH:
                $this->model->withTrashed();
                break;
            case self::ONLY_TRASH:
                $this->model->onlyTrashed();
                break;
            case self::NO_TRASH:
            default:
                break;
        }

        switch ($size) {
            case -1:
                return $this->model->get();
                break;
            case 0:
                return $this->model->first();
            default:
                return $this->model->paginate($size);
                break;
        }
    }


    /**
     * Lấy thông tin 1 bản ghi đã bị xóa softDelete được xác định bởi ID
     *
     * @param  integer $id ID bản ghi
     *
     * @return Eloquent
     */
    public function getByIdInTrash($id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    /**
     * Lưu thông tin 1 bản ghi mới
     *
     * @param  array $data
     *
     * @return Eloquent
     */
    public function store($data)
    {
        return $this->model->create($data);
    }

    /**
     * Cập nhật thông tin 1 bản ghi theo ID
     *
     * @param  integer $id ID bản ghi
     *
     * @return Eloquent
     */
    public function update($id, $data, $excepts = [], $only = [])
    {
        $data = array_except($data, $excepts);
        if (count($only)) {
            $data = array_only($data, $only);
        }
        $record = $this->getById($id);
        $record->fill($data)->save();
        return $record;
    }

    /**
     * Lấy thông tin 1 bản ghi xác định bởi ID
     *
     * @param  integer $id      ID bản ghi
     * @param  boolean $trash   Có lấy softDeletes
     * @param  boolean $useHash Có sử dụng hash hay không
     *
     * @return Eloquent
     */
    public function getById($id, $trash = false, $useHash = false)
    {
        $model = $this->model;
        if ($trash) {
            $model = $model->withTrashed();
        }
        if ($useHash && !is_numeric($id)) {
            return $model->findOrFail(hashid_decode($id));
        }
        return $model->findOrFail($id);
    }

    /**
     * Xóa 1 bản ghi. Nếu model xác định 1 SoftDeletes
     * thì method này chỉ đưa bản ghi vào trash. Dùng method destroy
     * để xóa hoàn toàn bản ghi.
     *
     * @param  integer $id ID bản ghi
     *
     * @return bool|null
     */
    public function delete($id)
    {
        $record = $this->getById($id);
        return $record->delete();
    }

    /**
     * Xóa hoàn toàn một bản ghi
     *
     * @param  integer $id ID bản ghi
     *
     * @return bool|null
     */
    public function destroy($id)
    {
        $record = $this->getById($id);
        return $record->forceDelete();
    }

    /**
     * Khôi phục 1 bản ghi SoftDeletes đã xóa
     *
     * @param  integer $id ID bản ghi
     *
     * @return bool|null
     */
    public function restore($id)
    {
        $record = $this->getByIdInTrash($id);
        return $record->restore();
    }
}
