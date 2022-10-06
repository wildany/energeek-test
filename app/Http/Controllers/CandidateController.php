<?php

namespace App\Http\Controllers;

use App\Models\candidate;
use App\Models\skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class CandidateController extends Controller
{
    public function createCandidate(Request $request): JsonResponse
    {

        $rules = [
            'job_id' => 'required',
            'name' => 'required',
            'email' => 'required|email:rfc|unique:candidates',
            'phone' => 'required|numeric|unique:candidates',
            'year' => 'required|numeric',
            'skill_sets.*' => 'required|distinct'

        ];
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah terdaftar',
            'email' => ':attribute tidak valid',
            'distinct' => ':attribute tidak boleh redundant'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        $job_id = $request->input('job_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $year = $request->input('year');
        $candidateSkills = $request->input('skill_sets.*');
        $creator = (int)$request->header('Guest');
        $data = candidate::create([
            'job_id' => $job_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'year' => $year,
            'created_by' => $creator
        ]);
        $dataSkill = skill::find($candidateSkills);
        $data->skill()->attach($dataSkill);
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

    public function getAllCandidates(): JsonResponse
    {
        $data = candidate::all();
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
        // var_dump(Auth::id());
        return $response;
    }

    public function getCandidateById($id): JsonResponse
    {
        $data = candidate::find($id);
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

    public function updateCandidate(Request $request): JsonResponse
    {
        $rules = [
            'job_id' => 'required',
            'name' => 'required',
            'email' => 'required|email:rfc',
            'phone' => 'required|numeric',
            'year' => 'required|numeric'
        ];
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah terdaftar',
            'email' => ':attribute tidak valid'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        $id = $request->input('id');
        $job_id = $request->input('job_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $year = $request->input('year');
        $data = candidate::find($id);
        $updater = (int)$request->header('Guest');
        $status = "";
        $statusCode = 0;
        $cekEmail = candidate::where('email', '=', $email)->where('id', '!=', $id)->get()->count();
        $cekPhone = candidate::where('phone', '=', $phone)->where('id', '!=', $id)->get()->count();

        if ($cekEmail != 0) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email sudah terdaftar'
            ]);
        }

        if ($cekPhone != 0) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Phone sudah terdaftar'
            ]);
        }

        if ($data) {
            $data->update([
                'job_id' => $job_id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'year' => $year,
                'updated_by' => $updater
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

    public function deleteCandidate(Request $request): JsonResponse
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
        $data = candidate::find($id);
        $status = "";
        $statusCode = 0;

        if ($data) {
            $data->skill()->detach();
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
