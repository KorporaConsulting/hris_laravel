<?php

namespace App\Exports;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KehadiranExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {               
        return User::with(['kehadiran' => function ($q) {
            $q->select('user_id', DB::raw('count(type) as total, type'));
            $q->groupBy('type');
        }])
        ->select('id', 'name')
        ->get()
        ->map(function ($value, $key) {
            $value['id'] = $key+1;
            $value['hadir'] = '0';
            $value['telat'] = '0';
            $value['alpha'] = '0';
            $value['cuti'] = '0';

            foreach ($value->kehadiran as $k => $v) {
                $value[$v->type] = $v->total;
            }

            unset($value['kehadiran']);

            return $value;
        });
    }

    public function headings(): array
    {
        return [
            'no',
            'name',
            'hadir',
            'telat',
            'alpha',
            'cuti',
        ];
    }
}
