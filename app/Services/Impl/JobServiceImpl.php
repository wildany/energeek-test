<?php

namespace App\Services\Impl;

use App\Repositories\JobRepository;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobServiceImpl implements JobService
{
    public function __construct(private JobRepository $jobRepository)
    {
    }

    public function createJob(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $creator = (int)$request->header('Guest');
        $data = $this->jobRepository->createJob($name, $creator);
        $status = "";
        $statusCode = 0;

        if ($data) {
            $status = 'success';
            $statusCode = 201;
        } else {
            $status = 'failed';
            $statusCode = 400;
        }

        $response = response()->json(
            [
                'status' => $status,
                'data' => $data,
            ],
            $statusCode
        );

        return $response;
    }

    public function getAllJob(): JsonResponse
    {
        $data = $this->jobRepository->getAllJob();
        $status = "";
        $statusCode = 0;

        if ($data) {
            $status = "success";
            $statusCode = "200";
        } else {
            $status = "failed";
            $statusCode = "404";
        }

        $response = response()->json(
            [
                'status' => $status,
                'data' => $data,
            ],
            $statusCode
        );

        return $response;
    }

    public function getJobById($id): JsonResponse
    {
        $data = $this->jobRepository->getJobById($id);
        $status = "";
        $statusCode = 0;

        if ($data) {
            $status = "success";
            $statusCode = "200";
        } else {
            $status = "failed";
            $statusCode = "404";
        }

        $response = response()->json(
            [
                'status' => $status,
                'data' => $data,
            ],
            $statusCode
        );

        return $response;
    }

    public function updateJob(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $updater = (int)$request->header('Guest');
        $data = $this->jobRepository->getJobById($id);
        $status = "";
        $statusCode = 0;
        if ($data) {
            $this->jobRepository->updateJob($id, $name, $updater);
            $status = "success";
            $statusCode = "200";
        } else {
            $status = "failed";
            $statusCode = 400;
        }

        $response = response()->json(
            [
                'status' => $status,
                'data' => $data,
            ],
            $statusCode
        );
        // var_dump($updater);
        return $response;
    }

    public function deleteJob(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $destroyer = (int)$request->header('Guest');
        $data = $this->jobRepository->getJobById($id);
        $status = "";
        $statusCode = 0;

        if ($data) {
            $this->jobRepository->updateJobDestroyer($id, $destroyer);
            $this->jobRepository->deleteJob($id);
            $status = "success";
            $statusCode = "200";
        } else {
            $status = "failed";
            $statusCode = 400;
        }

        $response = response()->json(
            [
                'status' => $status,
                'data' => $data,
            ],
            $statusCode
        );

        var_dump($destroyer);
        return $response;
    }
}
