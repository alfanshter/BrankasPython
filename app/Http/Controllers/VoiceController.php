<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VoiceController extends Controller
{
    function check_voice(Request $request) {
        $data = $request->all();

        //update nilai is finger di tabel pengguna
        $voice = Pengguna::where('is_voice',$request->is_voice)->first();

        if ($voice!=null) {
            $addvoice = Voice::create([
                'nama' => $voice->nama,
                'status' => 1,
                'text' => $request->is_voice
            ]);
        }else{
            $addvoice = Voice::create([
                'nama' => 'Unkow',
                'status' => 0,
                'text' => $request->is_voice
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

    
    function register_voice(Request $request){
        $data = $request->all();

        //update nilai is finger di tabel pengguna
        $post = Pengguna::where('id',$request->id_user)->update([
            'is_voice' => $request->is_voice
        ]);

        //ubah status alat ke stanby
        $updatealat = DB::table('status_alats')->update([
            'status' => 'stanby'
        ]);

        //kirim response ke raspi dalam bentuk json 
        $response = [
            'message' => 'Voice registration successful',
            'status' => 1,
            'data' => $post
        ];

        return response()->json($response, Response::HTTP_OK);

    }

    function read_voice(Request $request){
        $finger = Voice::with('pengguna')->get();
         //kirim response ke raspi dalam bentuk json 
         $response = [
            'message' => 'finger success',
            'status' => 1,
            'data' => $finger
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
