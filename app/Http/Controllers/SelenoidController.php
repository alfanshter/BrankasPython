<?php

namespace App\Http\Controllers;

use App\Models\Selenoid;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SelenoidController extends Controller
{
    function store(Request $request)
    {
        $data = DB::table('selenoids')->first();
        if ($data != null) {
            try {
                $update = DB::table('selenoids')->update([
                    'status' => $request->status
                ]);

                $response = [
                    'message' => 'sukses',
                    'data' => null,
                    'status' => 1
                ];

                return response()->json($response, Response::HTTP_OK);
            } catch (QueryException $th) {
                $response = [
                    'message' => $th->getMessage(),
                    'data' => null,
                    'status' => 0
                ];

                return response()->json($response, Response::HTTP_OK);
            }
        } else {
            try {
                $create = Selenoid::create([
                    'status' => $request->status
                ]);

                $response = [
                    'message' => 'sukses',
                    'data' => null,
                    'status' => 1
                ];

                return response()->json($response, Response::HTTP_OK);
            } catch (QueryException $th) {
                $response = [
                    'message' => $th->getMessage(),
                    'data' => null,
                    'status' => 0
                ];

                return response()->json($response, Response::HTTP_OK);
            }
        }
    }

    function index()
    {
        $data = DB::table('selenoids')->first();

        $response = [
            'message' => 'sukses',
            'data' => $data,
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
