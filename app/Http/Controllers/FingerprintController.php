<?php

namespace App\Http\Controllers;

use App\Models\Finger;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FingerprintController extends Controller
{
    function register_finger(Request $request)
    {
        $data = $request->all();

        //update nilai is finger di tabel pengguna
        $post = Pengguna::where('id', $request->id_user)->update([
            'is_finger' => $request->is_finger
        ]);

        //ubah status alat ke stanby
        $updatealat = DB::table('status_alats')->update([
            'status' => 'stanby'
        ]);

        //kirim response ke raspi dalam bentuk json 
        $response = [
            'message' => 'Daftar finger berhasil',
            'status' => 1,
            'data' => $post
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    function check_finger(Request $request)
    {
        $data = $request->all();

        //update nilai is finger di tabel pengguna
        $finger = Pengguna::where('is_finger', $request->is_finger)->first();

        if ($finger != null) {
            $addfinger = Finger::create([
                'nama' => $finger->nama,
                'status' => 1
            ]);
        } else {
            $addfinger = Finger::create([
                'nama' => 'Unkow',
                'status' => 0
            ]);
        }

        //ubah status alat ke stanby
        $updatealat = DB::table('status_alats')->update([
            'status' => 'stanby'
        ]);

        //kirim response ke raspi dalam bentuk json 
        $response = [
            'message' => 'finger success',
            'status' => 1,
            'data' => null
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    function read_finger(Request $request){
        $finger = Finger::with('pengguna')->get();
         //kirim response ke raspi dalam bentuk json 
         $response = [
            'message' => 'finger success',
            'status' => 1,
            'data' => $finger
        ];

        return response()->json($response, Response::HTTP_OK);
    }

 
}
