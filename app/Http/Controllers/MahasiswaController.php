<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMahasiswa()
    {
        $mahasiswa = Mahasiswa::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'succes',
            'data' => $mahasiswa,
            
        ];
        return response()-> json($response, 200);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'name' => ['required'],
            'NIM' => ['required', 'numeric'],
            'jeniskelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'prodi' => ['required', 'in:Teknik Informatika, Sistem Informasi, Sistem Komputer']
        ]);
        if ($validator-> fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
                $mahasiswa = Mahasiswa::create($request->all());
                $response = [
                    'message' => 'succes',
                    'data' => $mahasiswa
                ];
                return response()->json($response, Response::HTTP_CREATED);
        }catch(QueryException $e) {
            return response()->json([
                    'message' => "succes" . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // menampilkan spesik data by id
        $mahasiswa = Mahasiswa::findOrFail($id);
        $response = [
            'message' => 'succes',
            'data' => $mahasiswa
        ];
        return response()->json($response, Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)

    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $validator= Validator::make($request->all(), [
            'name' => ['required'],
            'NIM' => ['required', 'numeric'],
            'jeniskelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'prodi' => ['required', 'in:Teknik Informatika,Sistem Informasi,Sistem Komputer']
        ]);
        if ($validator-> fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
                $mahasiswa->update($request->all());
                $response = [
                    'message' => 'succes',
                    'data' => $mahasiswa
                ];
                return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $e) {
            return response()->json([
                    'message' => "succes" . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        try {
                $mahasiswa->delete();
                $response = [
                    'message' => 'succes',
                ];
                return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $e) {
            return response()->json([
                    'message' => "succes" . $e->errorInfo
            ]);
        }
    }
}
