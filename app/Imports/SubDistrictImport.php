<?php

namespace App\Imports;

use App\Models\Admin\SubDistrict;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Admin\District;
use App\Models\Admin\State;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubDistrictImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        echo '<pre>';
        print_r($row);
        $State = State::where(['name' => $row['state_name']])->first()->toArray();
        $District = District::where(['name' => $row['district_name']])->first()->toArray();

        $village = SubDistrict::where(['name' => $row['subdistrict_name'], 'district_id' => $District['id'], 'state_id' => $State['id']])->first();

        if (empty($village)) {

            return new SubDistrict([
                'country_id' => 1,
                'state_id' => isset($State['id']) ? $State['id'] : "",
                'district_id' => isset($District['id']) ? $District['id'] : "",
                'name' => $row['subdistrict_name'],
                'is_active' => '1',
                'is_active_at' => date('Y-m-d H:i:s')
            ]);
            // Village::where(['name' => $row['village_name'], 'subdistrict_id' => $SubDistrict_A['id'], 'district_id' => $District_A['id'], 'state_id' => $State['id']])->delete();
        }
        // print_r($State['id']);
        // print_r([
        //     'country_id' => 1,
        //     'state_id' => isset($State['id']) ? $State['id'] : "",
        //     'district_id' => isset($District['id']) ? $District['id'] : "",
        //     'name' => $row['sub_district_name'],
        //     'is_active' => '1',
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);
        // echo '</pre>';
        // exit;
        // return new SubDistrict([
        //     'country_id' => 1,
        //     'state_id' => isset($State['id']) ? $State['id'] : "",
        //     'district_id' => isset($District['id']) ? $District['id'] : "",
        //     'name' => $row['subdistrict_name'],
        //     'is_active' => '1',
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);
    }
}
