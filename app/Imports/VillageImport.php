<?php

namespace App\Imports;

use App\Models\Admin\Village;
// use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Admin\District;
use App\Models\Admin\SubDistrict;
use App\Models\Admin\Block;
use App\Models\Admin\State;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use App\Imports\ReportImport;

class VillageImport implements WithHeadingRow, WithMultipleSheets
{
    use WithConditionalSheets;
    public function conditionalSheets(): array
    {
        return [
            // 'Report' => new ReportImport(),
            // 'Report1' => new ReportImport(),
            // 'Report2' => new ReportImport(),
            // 'Report3' => new ReportImport(),
            // 'Report4' => new ReportImport(),
            'Report5' => new ReportImport(),
            // 'Report6' => new ReportImport(),
            // 'Report7' => new ReportImport(),
            // 'Report8' => new ReportImport(),
            // 'Report9' => new ReportImport(),
            // 'Report10' => new ReportImport(),
            // 'blockvillage' => new ReportImport(),
            // 'blockvillage1' => new ReportImport(),
            // 'blockvillage2' => new ReportImport(),
            // 'blockvillage3' => new ReportImport(),
            // 'blockvillage6' => new ReportImport(),
            // 'blockvillage5' => new ReportImport(),
            // 'blockvillage6' => new ReportImport(),
            // 'blockvillage7' => new ReportImport(),
        ];
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     echo '<pre>';
    //     print_r($row);
    //     $State = State::where(['name' => $row['state_name']])->first()->toArray();
    //     $District = District::where(['name' => $row['district_name']])->first()->toArray();
    //     $SubDistrict = SubDistrict::where(['name' => $row['sub_district_name']])->first()->toArray();

    //     // // print_r($State['id']);
    //     print_r([
    //         'country_id' => 1,
    //         'state_id' => isset($State['id']) ? $State['id'] : "",
    //         'district_id' => isset($District['id']) ? $District['id'] : "",
    //         'subdistrict_id' => isset($SubDistrict['id']) ? $SubDistrict['id'] : "",
    //         'name' => $row['village_name'],
    //         'is_active' => '1',
    //         'is_active_at' => date('Y-m-d H:i:s')
    //     ]);
    //     echo '</pre>';
    //     exit;
    //     return new Village([
    //         'country_id' => 1,
    //         'state_id' => isset($State['id']) ? $State['id'] : "",
    //         'district_id' => isset($District['id']) ? $District['id'] : "",
    //         'name' => $row['district_name'],
    //         'is_active' => '1',
    //         'is_active_at' => date('Y-m-d H:i:s')
    //     ]);
    // }
}
