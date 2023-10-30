<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Security;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    function security(Request $request) {
        $data = $request->all();
        $is_status = 0;
        $pengguna = Pengguna::where('is_face',$request->face_name)->first();
        if ($pengguna!=null) {
            $data['nama'] = $pengguna->nama;
            $data['description'] = 'Success';
            $data['is_status'] = 1;
            
        }else{
            $data['nama'] = 'Unknow';
            $data['description'] = 'unknown face';
            $data['is_status'] = 0;
        }

        if ($request->file('face')) {
            //compress foto 
            $foto = $request->file('face');
            $fotoName = time() . '.' . $foto->extension();

            // open an image file
            $img = Image::make($foto->path());

            // prevent possible upsizing
            $img->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // finally we save the image as a new file
            $destinationPath = public_path('/storage/foto/' . $fotoName);
            
            $data['face'] = 'foto/' . $fotoName;
            $img->save($destinationPath);
            
        }

        if ($request->finger) {
            if ($pengguna->is_finger == $request->finger) {
                $data['finger'] = $request->finger;
            }else{
                $data['finger'] = 'unknow';
                $data['description'] = 'unknow finger';
                $data['is_status'] = 0;
            }
    
        }

        if ($request->voice) {
            if ($pengguna->is_voice == $request->voice) {
                $data['voice'] = $request->voice;
                $is_status = 1;
            }else{
                $data['voice'] = 'unknow';
                $data['description'] = 'unknow Voice';
                $data['is_status'] = 0;
            }
    
        }



 
        try {
            $post = Security::create($data);
               //ubah status alat ke stanby
            $updatealat = DB::table('status_alats')->update([
                'status' => 'stanby'
            ]);

            $response = [
                'message' => 'sukses',
                'data' => $post,
                'status' => $is_status
            ];
    
            return response()->json($response, Response::HTTP_OK);
                
        } catch (QueryException $th) {
            $response = [
                'message' => $th->getMessage(),
                'data' => null,
                'status' => $is_status
            ];
    
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    function read_security(){
        
        $data = Security::orderBy('created_at','desc')->get();
        $response = [
            'message' => 'sukses',
            'data' => $data,
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_OK);

    }
}
