<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TitikModel extends Model
{
    public function allData()
    {
        $results = DB::table('titik')
            ->select('nama', 'latitude', 'longitude')
            ->get();
        return $results;
    }

    public function getLokasi($id = '')
    {
        $results = DB::table('lokasi')
            ->select('nama', 'alamat', 'gambar')
            ->where('id', $id)
            ->get();
        return $results;
    }

    public function allLokasi()
    {
        $results = DB::table('lokasi')
            ->select('id', 'nama')
            ->get();
        return $results;
    }
}
