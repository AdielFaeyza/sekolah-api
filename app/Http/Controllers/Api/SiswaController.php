<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    private function success($data, $links = [], $statusCode = 200, $message = 'success')
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'links' => $links,
            'status_code' => $statusCode
        ], $statusCode);
    }

    private function failed($message = 'failed', $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            'status_code' => $statusCode
        ], $statusCode);
    }

    public function index()
    {
        $data = Siswa::all();

        $links = [
            'self' => url('/api/siswa'),
            'create' => url('/api/siswa')
        ];

        return $this->success($data, $links);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:siswa'
        ]);

        $siswa = Siswa::create($request->all());

        $links = [
            'self' => url('/api/siswa/'.$siswa->id),
            'collection' => url('/api/siswa')
        ];

        return $this->success($siswa, $links, 201, 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $links = [
            'self' => url('/api/siswa/'.$id),
            'update' => url('/api/siswa/'.$id),
            'delete' => url('/api/siswa/'.$id),
            'collection' => url('/api/siswa')
        ];

        return $this->success($siswa, $links);
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $siswa->update($request->all());

        $links = [
            'self' => url('/api/siswa/'.$id),
            'collection' => url('/api/siswa')
        ];

        return $this->success($siswa, $links, 200, 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $siswa->delete();

        $links = [
            'collection' => url('/api/siswa')
        ];

        return $this->success(null, $links, 200, 'Data berhasil dihapus');
    }
}