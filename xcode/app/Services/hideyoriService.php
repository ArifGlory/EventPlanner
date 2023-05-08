<?php

namespace App\Services;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class hideyoriService
{
    public function create($model, $data)
    {
        DB::beginTransaction();
        try {
            $create = $model::create($data);
        } catch (QueryException|\ErrorException $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
        DB::commit();
        return $create;
    }

    public function update($item, $data)
    {
//        DB::beginTransaction();
//        $update = $item->update($data);
//        if ($update) {
//            DB::commit();
//            return $update;
//        } else {
//            DB::rollBack();
//            return false;
//        }

        DB::beginTransaction();
        try {
            $update = $item->update($data);
        } catch (QueryException|\ErrorException $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
        DB::commit();
        return $update;

    }

    public function find($model, $id, $trashed = false)
    {
        if ($trashed == true) {
            $item = $model::withTrashed()->find($id);
        } else {
            $item = $model::find($id);
        }

        if ($item) {
            return $item;
        } else {
            return false;
        }
    }

    public function delete($model, $id, $force = false)
    {
        DB::beginTransaction();
        try {
            if ($force == false) {
                destroyFunction($id, $model, false);
            } else {
                destroyFunction($id, $model, true);
            }

            DB::commit();
        } catch (\ErrorException $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage(), $e->getCode());
        }
        return true;
    }

    public function deleteBulk($model, $ids, $force = false)
    {
        foreach ($ids as $id) {
            $this->delete($model, $id, $force);
        }
    }

    public function statusBulk($model, $ids, $status)
    {
        DB::beginTransaction();
        try {
            $update = $model::whereIn($model::PRIMARYKEY, $ids)->update([
                $model::FIELDSTATUS => $status
            ]);
        } catch (QueryException|\ErrorException $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage(), $e->getCode());
        }
        DB::commit();
        return $update;
    }

    public function restore($item)
    {
        DB::beginTransaction();
        try {
            $update = $item->restore();
        } catch (QueryException|\ErrorException $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
        DB::commit();
        return $update;

    }



}
