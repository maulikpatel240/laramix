<?php

namespace App\Imports;

use App\Models\Admin\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StateImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // echo '<pre>';
        // print_r($row);
        // print_r([
        //     'country_id' => 1,
        //     'name' => $row['state_name'],
        //     'UT' => $row['state_or_ut'] == 'U' ? '1' : '0',
        //     'is_active' => '1',
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);
        // echo '</pre>';
        // exit;
        return new State([
            'country_id' => 1,
            'name' => $row['state_name'],
            'UT' => $row['state_or_ut'] == 'U' ? '1' : '0',
            'is_active' => '1',
            'is_active_at' => date('Y-m-d H:i:s')
        ]);
    }
}
