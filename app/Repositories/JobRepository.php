<?php

namespace App\Repositories;

interface JobRepository
{
    public function createJob($name, $creator);
    public function getAllJob();
    public function getJobById($id);
    public function updateJob($id, $name, $updater);
    public function updateJobDestroyer($id, $destroyer);
    public function deleteJob($id);
}
