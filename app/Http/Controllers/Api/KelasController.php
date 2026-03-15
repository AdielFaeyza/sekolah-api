<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
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
        $data = Kelas::all();

        $links = [
            'self' => url('/api/kelas'),
            'create' => url('/api/kelas')
        ];

        return $this->success($data, $links);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas',
            'nama_kelas' => 'required'
        ]);

        $kelas = Kelas::create($request->all());

        $links = [
            'self' => url('/api/kelas/'.$kelas->id),
            'collection' => url('/api/kelas')
        ];

        return $this->success($kelas, $links, 201, 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $links = [
            'self' => url('/api/kelas/'.$id),
            'update' => url('/api/kelas/'.$id),
            'delete' => url('/api/kelas/'.$id),
            'collection' => url('/api/kelas')
        ];

        return $this->success($kelas, $links);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $kelas->update($request->all());

        $links = [
            'self' => url('/api/kelas/'.$id),
            'collection' => url('/api/kelas')
        ];

        return $this->success($kelas, $links, 200, 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $kelas->delete();

        $links = [
            'collection' => url('/api/kelas')
        ];

        return $this->success(null, $links, 200, 'Data berhasil dihapus');
    }
}