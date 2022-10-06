<?php

namespace App\Http\Controllers;

use App\Models\job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
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

        $name = $request->input('name');
        $creator = (int)$request->header('Guest');
        $data = job::create(['name' => $name, 'created_by' => $creator]);
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
        $data = job::all();
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
        $data = job::find($id);
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

        $id = $request->input('id');
        $name = $request->input('name');
        $updater = (int)$request->header('Guest');
        $data = job::find($id);
        $status = "";
        $statusCode = 0;
        if ($data) {
            $data->update(['id' => $id, 'name' => $name, 'updated_by' => $updater]);
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

        return $response;
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

        $id = $request->input('id');
        $destroyer = (int)$request->header('Guest');
        $data = job::find($id);
        $status = "";
        $statusCode = 0;

        if ($data) {
            $data->delete(['id' => $id]);
            $data->update([
                'deleted_by' => $destroyer
            ]);
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
        return $response;
    }
}
