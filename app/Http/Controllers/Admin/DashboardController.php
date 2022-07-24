<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StateImport;
use App\Imports\DistrictImport;
use App\Imports\BlockImport;
use App\Imports\SubDistrictImport;
use App\Imports\VillageImport;
use App\Imports\DepartmentImport;
use Illuminate\Http\Request;
use Excel;
use App\Notifications\SendPushNotification;
use Notification;
use App\Models\User;
use App\Models\Admin\Devices;
use Kutia\Larafirebase\Facades\Larafirebase;
// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        parent::__construct();
    }

    public function index()
    {
        // global $user;
        return view('admin.dashboard');
    }
    public function import(Request $request)
    {
        ini_set('max_execution_time', 0);
        // echo '<pre>'; print_r($request->all()); echo '</pre>'; exit;
        // $import = new VillageImport();
        $import = new DepartmentImport();
        //Report4 check it again  data village
        // $import->onlySheets('Report','Report1','Report2','Report3','Report4','Report5','Report6','Report7','Report8','Report9','Report10');
        $import->onlySheets('Report');
        // Excel::import($import, $request->file);
        // Excel::import(new BlockImport, $request->file);
        // Excel::import(new StateImport, $request->file);
        // Excel::import(new DistrictImport, $request->file);
        // Excel::import(new SubDistrictImport, $request->file);
        // Excel::import(new DepartmentImport, $request->file);
        return "Imported successfully";
    }

    public function updateToken(Request $request)
    {
        try {
            $DevicesModel = Devices::where("id", auth()->user()->id)->where("fcm_token", $request->token)->first();
            if (empty($DevicesModel)) {
                $DevicesModel = new Devices;
                $DevicesModel->member_id = auth()->user()->id;
                $DevicesModel->type = "android";
                $DevicesModel->udid = "unique-device-udid";
                $DevicesModel->os =  "Android";
                $DevicesModel->os_version =  "8.0";
                $DevicesModel->manufacturer =  "Samsung";
                $DevicesModel->model =  "Galaxy S10";
                $DevicesModel->app_version =  "1.0.1";
                $DevicesModel->fcm_token =  $request->token;
                $DevicesModel->ipv4 = "127.0.0.1";
                $DevicesModel->save();
            }
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
        ]);

        try {
            $fcmTokens = Devices::whereNotNull('fcm_token')->where("id", auth()->user()->id)->pluck('fcm_token')->toArray();
            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success', 'Notification Sent Successfully!!');
        } catch (\Exception $e) {
            report($e);
            // return redirect()->back()->with('error', 'Something goes wrong while sending notification.');
        }
    }
}
