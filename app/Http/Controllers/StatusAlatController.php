<?php

namespace App\Http\Controllers;

use App\Models\StatusAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class StatusAlatController extends Controller
{
    function store(Request $request)
    {
        $data = DB::table('status_alats')->first();
        if ($data != null) {
            $update = DB::table('status_alats')->update([
                'status' => $request->status,
                'id_user' => $request->id_user
            ]);

            return response()->json(['message' => 'Data successfully received and processed']);
        } else {
            $create = StatusAlat::create([
                'status' => $request->status,
                'id_user' => $request->id_user
            ]);
            return response()->json(['message' => 'Data successfully received and processed']);
        }
    }

    function index()
    {
        $data = DB::table('status_alats')->first();
        if ($data != null) {
            $response = [
                'message' => 'Success',
                'data' => $data,
                'status' =>1
            ];

            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'Safely operate the device using your Android device first',
                'data' => $data,
                'status' =>1
            ];

            return response()->json($response, Response::HTTP_OK);
        }
    }
}
