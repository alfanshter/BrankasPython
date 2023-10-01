<?php

namespace App\Http\Controllers;

use App\Models\Face;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FacePrintController extends Controller
{
    
    function register_face(Request $request) {
        $data = $request->all();

        //update nilai is face di tabel pengguna
        $post = Pengguna::where('id',$request->id_user)->update([
            'is_face' => $request->is_face
        ]);

        //ubah status alat ke stanby
        $updatealat = DB::table('status_alats')->update([
            'status' => 'stanby'
        ]);

        //kirim response ke raspi dalam bentuk json 
        $response = [
            'message' => 'Daftar face berhasil',
            'status' => 1,
            'data' => $post
        ];

        return response()->json($response, Response::HTTP_OK);

    }

    function check_face(Request $request) {
        $data = $request->all();

        //update nilai is finger di tabel pengguna
        $voice = Pengguna::where('is_face',$request->is_face)->first();

        if ($voice!=null) {
            $addvoice = Face::create([
                'nama' => $voice->nama,
                'status' => 1
            ]);
        }else{
            $addvoice = Face::create([
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
            'message' => 'Voice success',
            'status' => 1,
            'data' => null
        ];

        return response()->json($response, Response::HTTP_OK);

    }

    function read_face(Request $request){
        $finger = Face::with('pengguna')->get();
         //kirim response ke raspi dalam bentuk json 
         $response = [
            'message' => 'finger success',
            'status' => 1,
            'data' => $finger
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
