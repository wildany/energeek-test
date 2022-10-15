<?php

namespace App\Http\Controllers;

use App\Models\job;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{

    public function __construct(private JobService $jobService)
    {
    }

    public function createJob(Request $request): JsonResponse
    {

        $rules = [
            'name' => 'required'
        ];
        $message = [
            'required' => ':attribute tidak boleh kosong'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        return $this->jobService->createJob($request);
    }

    public function getAllJob(): JsonResponse
    {
        return $this->jobService->getAllJob();
    }

    public function getJobById($id): JsonResponse
    {
        return $this->jobService->getJobById($id);
    }

    public function updateJob(Request $request): JsonResponse
    {
        $rules = [
            'id' => 'required',
            'name' => 'required'
        ];
        $message = [
            'required' => ':attribute tidak boleh kosong'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        return $this->jobService->updateJob($request);
    }

    public function deleteJob(Request $request): JsonResponse
    {
        $rules = [
            'id' => 'required',

        ];
        $message = [
            'required' => ':attribute tidak boleh kosong'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        return $this->jobService->deleteJob($request);
    }
}
