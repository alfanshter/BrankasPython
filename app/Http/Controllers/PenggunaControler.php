<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PenggunaControler extends Controller
{

    function adduser(Request $request)
    {

        $data = Pengguna::where('nama',$request->nama)->first();
     
        if ($data!=null) {
            $response = [
                'message' => 'data existing',
                'data' => null,
                'status' =>0
            ];
    
            return response()->json($response, Response::HTTP_OK);            
        }

        $pengguna = Pengguna::create([
            'nama' => $request->nama
        ]);
       
        $response = [
            'message' => 'sukses',
            'data' => $pengguna,
            'status' =>1
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    function readuser(Request $request)
    {
        $pengguna = Pengguna::orderBy('created_at','DESC')->get();
        $response = [
            'message' => 'sukses',
            'data' => $pengguna
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    function deleteuser(Request $request)
    {
        $pengguna = Pengguna::where('id',$request->id_user)->delete();
        $response = [
            'message' => 'sukses',
            'data' => $pengguna
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
