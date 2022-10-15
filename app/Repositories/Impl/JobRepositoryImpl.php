<?php

namespace App\Repositories\Impl;

use App\Models\job;
use App\Repositories\JobRepository;

class JobRepositoryImpl implements JobRepository
{
    public function __construct(private job $model)
    {
    }

    public function createJob($name, $creator)
    {
        return $this->model->create(['name' => $name, 'created_by' => $creator]);
    }
    public function getAllJob()
    {
        return $this->model->all();
    }

    public function getJobById($id)
    {
        return $this->model->find($id);
    }

    public function updateJob($id, $name, $updater)
    {
        return $this->model->where('id', $id)->update(['name' => $name, 'updated_by' => $updater]);
    }

    public function updateJobDestroyer($id, $destroyer)
    {
        return $this->model->where('id', $id)->update([
            'deleted_by' => $destroyer
        ]);
    }
    public function deleteJob($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
