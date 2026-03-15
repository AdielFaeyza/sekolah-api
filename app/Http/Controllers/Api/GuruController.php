<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
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
        $data = Guru::all();

        $links = [
            'self' => url('/api/guru'),
            'create' => url('/api/guru')
        ];

        return $this->success($data, $links);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:guru'
        ]);

        $guru = Guru::create($request->all());

        $links = [
            'self' => url('/api/guru/'.$guru->id),
            'collection' => url('/api/guru')
        ];

        return $this->success($guru, $links, 201, 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $links = [
            'self' => url('/api/guru/'.$id),
            'update' => url('/api/guru/'.$id),
            'delete' => url('/api/guru/'.$id),
            'collection' => url('/api/guru')
        ];

        return $this->success($guru, $links);
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $guru->update($request->all());

        $links = [
            'self' => url('/api/guru/'.$id),
            'collection' => url('/api/guru')
        ];

        return $this->success($guru, $links, 200, 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $guru->delete();

        $links = [
            'collection' => url('/api/guru')
        ];

        return $this->success(null, $links, 200, 'Data berhasil dihapus');
    }
}