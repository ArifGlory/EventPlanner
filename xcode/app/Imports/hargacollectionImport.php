<?php

namespace App\Imports;

use App\Models\HargaKomoditas;
use App\Models\Kabupaten;
use App\Models\KomoditasTernak;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class hargacollectionImport implements ToCollection, WithStartRow, WithCustomCsvSettings
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $komoditas_id = KomoditasTernak::where('komoditas', 'ilike', '%' . trim($row[1]) . '%')->first();
            $id_kab = Kabupaten::where('name', 'ilike', '%' . trim($row[2]) . '%')->first();
            if ($komoditas_id) {
                if ($id_kab) {
                    DB::beginTransaction();
                    try {
//                        $data = HargaKomoditas::where([['komoditas_id', $komoditas_id->id], ['id_kab', $id_kab->id], ['tgl', $row[0]]])->first();
                        HargaKomoditas::updateOrCreate([
                            'tgl' => $row[0],
                            'komoditas_id' => $komoditas_id->id,
                            'id_kab' => $id_kab->id,
                            'tingkat_harga' => $row[3],
                            'harga' => $row[4],
                            'status' => 'aktif',
                            'created_by' => Auth::user()->id_users,
                            'updated_by' => Auth::user()->id_users,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ]);


                    } catch (\ErrorException $e) {
                        DB::rollBack();
                        throw new ($e->getMessage());
                    }
                    DB::commit();
                }
            }
        }


    }
}
