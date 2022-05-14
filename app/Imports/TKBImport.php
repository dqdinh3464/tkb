<?php

namespace App\Imports;

use App\TKB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class TKBImport implements ToCollection, WithMappedCells
{
    public function collection(Collection $rows)
    {
//        $tkb = TKB::create([
//            'ho_ten' => $rows['ho_ten'],
//            'msv' => $rows['msv'],
//            'lop' => $rows['lop'],
//            'hoc_ky' => $rows['hoc_ky'],
//            'tkb' => [],
//        ]);
//
//        foreach ($rows as $key => $row) {
//            $thoi_gian = explode('-', $row[8]);
//            $tiet = explode(',', $row[6]);
//
//            $tkb->tkb->thu = $row[0];
//            $tkb->tkb->batdau = $thoi_gian[0];
//            $tkb->tkb->ketthuc = $thoi_gian[1];
//            $tkb->tkb->tiet = $row[6];
//            $tkb->tkb->mon = $row[3];
//            $tkb->tkb->diadiem = $row[7];
//            $tkb->tkb->giangvien = $row[5];
//            $tkb->tkb->row = $key + 1;
//            $tkb->tkb->ngay = $row[5];
//            $tkb->tkb->tiet_bat_dau = $tiet[0];
//        }
//
//        return $tkb;
    }

    public function startRow(): int
    {
        return 11;
    }

    public function mapping(): array
    {
        return [
            'ho_ten' => 'C6',
            'msv' => 'F6',
            'lop' => 'C7',
            'hoc_ky' => 'A4',
        ];
    }
}
