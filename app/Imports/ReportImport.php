<?php

namespace App\Imports;

use App\Models\Admin\Village;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Admin\District;
use App\Models\Admin\SubDistrict;
use App\Models\Admin\Block;
use App\Models\Admin\Department;
use App\Models\Admin\Festival;
use App\Models\Admin\Minister;
use App\Models\Admin\Relation;
use App\Models\Admin\Religion;
use App\Models\Admin\State;
use App\Models\Admin\Panchayat;
use App\Models\Admin\Category;
use App\Models\Admin\Typeofcategory;
use App\Models\Admin\Lang;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS;

class ReportImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ini_set('max_execution_time', 0);
        //Update District
        $State = State::where(['name' => $row['state_name']])->first();
        if ($State) {
            $District = District::where(['name' => $row['district_name'], 'state_id' => $State->id])->first();
            if (empty($District)) {
                $DistrictModel = new District;
                $DistrictModel->country_id = 1;
                $DistrictModel->state_id = $State->id;
                $DistrictModel->name = $row['district_name'];
                $DistrictModel->save();
            }
        }

        //Update SubDistrict
        $State = State::where(['name' => $row['state_name']])->first();
        if ($State) {
            $District = District::where(['name' => $row['district_name'], 'state_id' => $State->id])->first();
            if ($District) {
                $SubDistrict = SubDistrict::where(['name' => $row['subdistrict_name'], 'district_id' => $District->id, 'state_id' => $State->id])->first();
                if (empty($SubDistrict)) {
                    $SubDistrictModel = new District;
                    $SubDistrictModel->country_id = 1;
                    $SubDistrictModel->state_id = $State->id;
                    $SubDistrictModel->district_id = $District->id;
                    $SubDistrictModel->name = $row['subdistrict_name'];
                    $SubDistrictModel->save();
                }
            }
        }


        // if ($row["language_name"]) {
        //     $lang = Lang::where("name", $row["language_name"])->first();
        //     if (empty($lang)) {
        //         $lang = new Lang;
        //         $lang->lang_family = $row["language_family"];
        //         $lang->name = $row["language_name"];
        //         $lang->native = $row["native_name"];
        //         $lang->letter2 = $row["639_1"];
        //         $lang->letter3 = $row["639_2t"];
        //         $lang->note = $row["notes"];
        //         $lang->save();
        //     }
        // }
        // return new Relation([
        //     "name" => $row['relation'],
        //     // "date" => date("Y-m-d", strtotime($row['date'])),
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);
        // if ($row["name"]) {
        //     $Department = Category::where("name", $row["name"])->first();
        //     if ($Department) {
        //         if ($row["type"]) {
        //             $Typeofcategory = Typeofcategory::where("category_id", $Department->id)->where("type", $row["type"])->first();
        //             if ($Typeofcategory) {
        //             } else {
        //                 return new Typeofcategory([
        //                     'category_id' => $Department->id,
        //                     'type' => $row["type"],
        //                     'is_active_at' => date('Y-m-d H:i:s')
        //                 ]);
        //             }
        //         }
        //         // $Department->name = $row['name_short'];
        //         // $Department->type = ucfirst($row['type']);
        //         // $Department->save();
        //     } else {
        //         return new Category([
        //             'name' => $row['name'],
        //             'parent' => $row['parent'],
        //             'is_active_at' => date('Y-m-d H:i:s')
        //         ]);
        //     }
        // }

        //  if($row['minister_of_state']){
        //     return new Department([
        //         'department_id' => $Department->id,
        //         'minister_fullname' => $row['minister_of_state'],
        //         'minister' => "State Minister",
        //         'is_active' => '1',
        //         'is_active_at' => date('Y-m-d H:i:s')
        //     ]);
        //  }
        // if($row['minister_of_state1']){
        //     return new Minister([
        //         'department_id' => $Department->id,
        //         'minister_fullname' => $row['minister_of_state1'],
        //         'minister' => "State Minister",
        //         'is_active' => '1',
        //         'is_active_at' => date('Y-m-d H:i:s')
        //     ]);
        // }
        // if($row['minister_of_state2']){
        //     return new Minister([
        //         'department_id' => $Department->id,
        //         'minister_fullname' => $row['minister_of_state2'],
        //         'minister' => "State Minister",
        //         'is_active' => '1',
        //         'is_active_at' => date('Y-m-d H:i:s')
        //     ]);
        // }

        // }
        // if(isset($row['name']) && $row['name']){
        //     return new Department([
        //         'name' => $row['name'],
        //         'is_active' => '1',
        //         'is_active_at' => date('Y-m-d H:i:s')
        //     ]);
        // }


        // $State = State::where(['name' => $row['state_name']])->first();
        // $District = District::where(['name' => $row['district_name']])->first();
        // // $SubDistrict = SubDistrict::where(['name' => $row['subdistrict_name']])->first();
        // $State_A = $State ? $State->toArray() : "";
        // if ($State_A) {
        //     $Panchayat = Panchayat::where(['name' => $row['local_body_name'], 'state_id' => $State_A['id']])->first();
        //     if(empty($Panchayat)){
        //         return new Panchayat([
        //             'country_id' => 1,
        //             'state_id' => $State_A ? $State_A['id'] : null,
        //             'name' => $row['local_body_name'],
        //             'local_name' => $row['local_body_name_local'],
        //             'is_active' => '1',
        //             'is_active_at' => date('Y-m-d H:i:s')
        //         ]);
        //     }
        // }
        // $District_A = $District ? $District->toArray() : "";
        // $SubDistrict_A = $SubDistrict ? $SubDistrict->toArray() : "";
        // if ($State_A && $District_A && $SubDistrict_A) {
        //     // print_r($SubDistrict_A);
        //     $village = Village::where(['name' => $row['village_name'], 'subdistrict_id' => $SubDistrict_A['id'], 'district_id' => $District_A['id'], 'state_id' => $State_A['id']])->first();

        //     // echo '<pre>'; print_r($village); echo '</pre>'; exit;
        //     if ($village) {
        //         if (isset($row['local_body_name']) && $row['local_body_name']) {
        //             // $Panchayat = Panchayat::where(['name' => $row['local_body_name'], 'state_id' => $State_A['id']])->first();
        //             $village->panchayat_name = $row['local_body_name'];
        //             $village->save();
        //             echo "<pre>";
        //             print_r([
        //                 'no' => isset($row['sno']) && $row['sno'] ? $row['sno'] : "",
        //                 'panchayat_name' => $village->panchayat_name,
        //                 'village_name' => $village->name,
        //                 'village_id' => $village->id,
        //             ]);
        //             echo "</pre>";
        //         }
        //         // if ($row['local_body_name']) {
        //         //     $block_name =  (strtolower($row['block_namein_english']) == strtolower($SubDistrict_A['name'])) ? "" : $row['block_namein_english'];
        //         //     // print_r([
        //         //     //     'block_name' => $block_name,
        //         //     //     'village' => $village->id,
        //         //     // ]);
        //         //     $requestAll = [
        //         //         'block_name' => $block_name,
        //         //     ];
        //         //     print_r($requestAll);
        //         //     $village->block_name = $block_name;
        //         //     $village->save();
        //         //     print_r([
        //         //         'block_name' => $village->block_name,
        //         //         'village_name' => $village->name,
        //         //         'village_id' => $village->id,
        //         //     ]);
        //         // }
        //         // return new Village([
        //         //     'country_id' => 1,
        //         //     'state_id' => $State_A ? $State_A['id'] : null,
        //         //     'district_id' => $District_A  ? $District['id'] : null,
        //         //     'subdistrict_id' => $SubDistrict_A ? $SubDistrict['id'] : null,
        //         //     'name' => $row['village_name'],
        //         //     'status' => $row['village_status'],
        //         //     'is_active' => '1',
        //         //     'is_active_at' => date('Y-m-d H:i:s')
        //         // ]);
        //     }
        // }

        // // // print_r($State['id']);
        // print_r([
        //     'country_id' => 1,
        //     'state_id' => isset($State_A['id']) ? $State['id'] : "",
        //     'district_id' => isset($District_A['id']) ? $District['id'] : "",
        //     'subdistrict_id' => isset($SubDistrict_A['id']) ? $SubDistrict['id'] : "",
        //     'name' => $row['village_name'],
        //     'status' => $row['village_status'],
        //     'update' => $village > 1 ? "Multiple" : "Single",
        // ]);
        // echo '</pre>';
        // exit;
        // return new Village([
        //     'country_id' => 1,
        //     'state_id' => $State_A ? $State['id'] : null,
        //     'district_id' => $District_A  ? $District['id'] : null,
        //     'subdistrict_id' => $SubDistrict_A ? $SubDistrict['id'] : null,
        //     'name' => $row['village_name'],
        //     'status' => $row['village_status'],
        //     'is_active' => '1',
        //     'is_active_at' => date('Y-m-d H:i:s')
        // ]);

        // [sno] => 1
        // [state_code] => 35
        // [state_namein_english] => ANDAMAN AND NICOBAR ISLANDS
        // [state_census_code] => 35
        // [district_code] => 603
        // [district_namein_english] => NICOBARS
        // [district_census_code] => 638
        // [subdistrict_code] => 5916
        // [subdistrict_namein_english] => Car Nicobar
        // [subdistrict_census_code] => 5916
        // [village_code] => 645015
        // [village_namein_english] => Arong
        // [village_census_code] => 645015
        // [block_code] => 6499
        // [block_namein_english] => CAR NICOBAR
    }
}
