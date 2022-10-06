<?php

namespace App\Http\Controllers;

use App\Models\skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    public function createSkill(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required|unique:skills'
        ];
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => 'skill :attribute sudah terdaftar'
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
        $data = skill::create(['name' => $name, 'created_by' => $creator]);

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

    public function getAllSkills(): JsonResponse
    {
        $data = skill::all();
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

    public function getSkillById($id): JsonResponse
    {
        $data = skill::find($id);
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

    public function updateSkill(Request $request): JsonResponse
    {
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required'
        ];
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus angka'
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
        $data = skill::find($id);
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

    public function deleteSkill(Request $request): JsonResponse
    {
        $rules = [
            'id' => 'required|numeric',
        ];
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus angka'
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
        $data = skill::find($id);
        $status = "";
        $statusCode = 0;

        if ($data) {
            $data->delete(['id' => $id]);
            $data->update(['updated_by' => $destroyer]);
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
