<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
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
        $data = Mapel::all();

        $links = [
            'self' => url('/api/mapel'),
            'create' => url('/api/mapel')
        ];

        return $this->success($data, $links);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapel',
            'nama_mapel' => 'required'
        ]);

        $mapel = Mapel::create($request->all());

        $links = [
            'self' => url('/api/mapel/'.$mapel->id),
            'collection' => url('/api/mapel')
        ];

        return $this->success($mapel, $links, 201, 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $links = [
            'self' => url('/api/mapel/'.$id),
            'update' => url('/api/mapel/'.$id),
            'delete' => url('/api/mapel/'.$id),
            'collection' => url('/api/mapel')
        ];

        return $this->success($mapel, $links);
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $mapel->update($request->all());

        $links = [
            'self' => url('/api/mapel/'.$id),
            'collection' => url('/api/mapel')
        ];

        return $this->success($mapel, $links, 200, 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $mapel->delete();

        $links = [
            'collection' => url('/api/mapel')
        ];

        return $this->success(null, $links, 200, 'Data berhasil dihapus');
    }
}