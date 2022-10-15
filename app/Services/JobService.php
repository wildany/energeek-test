<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface JobService
{
    public function createJob(Request $request): JsonResponse;
    public function getAllJob(): JsonResponse;
    public function getJobById($id): JsonResponse;
    public function updateJob(Request $request): JsonResponse;
    public function deleteJob(Request $request): JsonResponse;
}
