<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
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
        $data = Jadwal::with(['kelas','mapel','guru'])->get();

        $links = [
            'self' => url('/api/jadwal'),
            'create' => url('/api/jadwal')
        ];

        return $this->success($data, $links);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id' => 'required|exists:guru,id',
            'hari' => 'required',
            'jam_pelajaran' => 'required'
        ]);

        $jadwal = Jadwal::create($request->all());

        $links = [
            'self' => url('/api/jadwal/'.$jadwal->id),
            'collection' => url('/api/jadwal')
        ];

        return $this->success($jadwal, $links, 201, 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['kelas','mapel','guru'])->find($id);

        if (!$jadwal) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $links = [
            'self' => url('/api/jadwal/'.$id),
            'update' => url('/api/jadwal/'.$id),
            'delete' => url('/api/jadwal/'.$id),
            'collection' => url('/api/jadwal')
        ];

        return $this->success($jadwal, $links);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $jadwal->update($request->all());

        $links = [
            'self' => url('/api/jadwal/'.$id),
            'collection' => url('/api/jadwal')
        ];

        return $this->success($jadwal, $links, 200, 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return $this->failed('Data tidak ditemukan', 404);
        }

        $jadwal->delete();

        $links = [
            'collection' => url('/api/jadwal')
        ];

        return $this->success(null, $links, 200, 'Data berhasil dihapus');
    }
}