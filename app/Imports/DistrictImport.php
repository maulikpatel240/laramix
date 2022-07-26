<?php

namespace App\Imports;

use App\Models\Admin\District;
use App\Models\Admin\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistrictImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        echo '<pre>';
        $State = State::where(['name' => $row['state_name']])->first()->toArray();

        $village = District::where(['name' => $row['district_name'], 'state_id' => $State['id']])->first();
        if (empty($village)) {
            return new District([
                'country_id' => 1,
                'state_id' => isset($State['id']) ? $State['id'] : "",
                'name' => $row['district_name'],
                'is_active' => '1',
                'is_active_at' => date('Y-m-d H:i:s')
            ]);
            // Village::where(['name' => $row['village_name'], 'subdistrict_id' => $SubDistrict_A['id'], 'district_id' => $District_A['id'], 'state_id' => $State['id']])->delete();
        }
        // print_r($State['id']);
        // print_r([
        //     'country_id' => 1,
        //     'state_id' => isset($State['id']) ? $State['id'] : "",
        //     'name' => $row['district_name'],
        //     'is_active' => '1',
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);
        // echo '</pre>';
        // exit;
        // return new District([
        //     'country_id' => 1,
        //     'state_id' => isset($State['id']) ? $State['id'] : "",
        //     'name' => $row['district_name'],
        //     'is_active' => '1',
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);
    }
}
