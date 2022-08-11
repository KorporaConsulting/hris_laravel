<?php

namespace App\Imports;

use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToCollection
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $karyawanBatch = [];


        $message = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The Email field is unique.',
        ];

        for ($i = 0; $i < count($rows); $i++) {
            if($i == 0){
                continue;
            }
            $validator = Validator::make($rows->toArray(), [
                '*.1' => 'unique:users,email',
                '*.2' => 'required',
                '*.3' => 'required',
            ], $message)->validate();

            $userInsert = [
                'name' => $rows[$i][0],
                'email' => $rows[$i][1],
                'password' => bcrypt($rows[$i][2]),
            ];

            if(!empty($rows[$i][3])){
                $userInsert['wfh_day'] = $rows[$i][3];
            }
            
            $user = User::create($userInsert);
            $user->assignRole($rows[$i][4]);
            $data = [
                'user_id'           => $user->id,
                'nip'               => $rows[$i][5],
                'jabatan'           => $rows[$i][6],
                'mulai_kerja'       => Carbon::create($rows[$i][7])->format('Y-m-d'),
                'tmpt_lahir'        => $rows[$i][8],
                'tgl_lahir'         => Carbon::create($rows[$i][9])->format('Y-m-d'),
                'alamat_ktp'        => $rows[$i][10],
                'alamat_domisili'   => $rows[$i][11],
                'no_hp'             => $rows[$i][12],
                'no_hp_darurat'     => $rows[$i][13],
                'status_pekerja'    => $rows[$i][14],
                'lama_kontrak'      => $rows[$i][15],
                'gaji'              => str_replace('.', '', $rows[$i][16]),
                'sisa_cuti'         => 0,
                'is_active'         => $rows[$i][18],
                'created_at'         => date('Y-m-d H:i:s'),
            ];

            if(strtolower($rows[$i][14]) != strtolower('pekerja tetap')){
                $data['habis_kontrak'] = '2022-10-10';
            }

            array_push($karyawanBatch, $data);
        }

        Karyawan::insert($karyawanBatch);
    }

}
