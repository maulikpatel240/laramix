<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UnsecureException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class UserController extends Controller
{
    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';
    const ACTIVE_INT = '1';
    const INACTIVE_INT = '0';
    const DELETE = 'Delete';

    public function __construct()
    {
        $this->middleware('auth:admin');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $sort = $request->sort;

        if (auth() && auth()->user() && auth()->user()->role_id != 1) {
            if ($sort) {
                $dataProvider = new EloquentDataProvider(Admin::query()->where('role_id', '!=', 1));
            } else {
                $dataProvider = new EloquentDataProvider(Admin::query()->where('role_id', '!=', 1)->orderBy('id', 'desc'));
            }
        } else {
            if ($sort) {
                $dataProvider = new EloquentDataProvider(Admin::query()->where('role_id', '!=', 5));
            } else {
                $dataProvider = new EloquentDataProvider(Admin::query()->where('role_id', '!=', 5)->orderBy('id', 'desc'));
            }
        }
        return view('admin.user.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function create()
    {
        $model = new Admin();
        return view('admin.user.create', ['model' => $model]);
    }

    public function store(UserRequest $request)
    {
        $requestAll = $request->all();
        $email_username = explode('@', $requestAll['email']);

        $requestAll['email_verified'] = '1';
        $requestAll['email_verified_at'] = currentDateTime();
        $requestAll['phone_number_verified'] = '0';
        $requestAll['password'] = Hash::make($requestAll['password']);
        $requestAll['is_active_at'] = currentDateTime();
        $token = Str::random(config('params.auth_key_character'));
        $requestAll['auth_key'] = hash('sha256', $token);
        $requestAll['username'] = $email_username ? $email_username[0] : $requestAll['first_name'] . '_' . $requestAll['last_name'] . '_' . random_int(101, 999);
        $model = new Admin();
        if ($request->ajax() && $model->create($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.user.index');
    }

    public function edit($id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.user.update', ['model' => $model]);
    }

    public function update(UserRequest $request, $id)
    {
        // $validated = $request->validated();
        $requestAll = $request->all();
        $requestAll['controller'] = $requestAll['controller'] ?? '';
        $requestAll['action'] = $requestAll['action'] ?? '';
        $model = $this->findModel(decode($id));
        if ($request->ajax() && $model->update($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.user.index');
    }

    public function changepassword($id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.user.changepassword', ['model' => $model]);
    }

    public function changepasswordupdate(ChangePasswordRequest $request, $id)
    {
        // $validated = $request->validated();
        $requestAll = $request->all();
        $requestAll['password'] = Hash::make($requestAll['password']);
        $model = $this->findModel(decode($id));
        if ($request->ajax() && $model->update($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.user.index');
    }

    public function view(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.user.view', ['model' => $model]);
    }

    public function delete(Request $request, $id)
    {
        Admin::where('id', decode($id))->delete();
        return redirect()->route('admin.user.index');
    }

    public function isactive(Request $request, $id)
    {
        if ($request->ajax()) {
            $model = $this->findModel(decode($id));
            $model->is_active = ($model->is_active == self::ACTIVE_INT) ? self::INACTIVE_INT : self::ACTIVE_INT;
            $model->is_active_at = currentDateTime();
            return $model->save();
        }
    }

    public function applystatus(Request $request)
    {
        if ($request->ajax()) {
            $inputall = $request->all();
            if (isset($inputall['applyoption'])) {
                if ($inputall['applyoption'] == self::ACTIVE) {
                    // if(empty(Yii::$app->BackFunctions->checkaccess('statusupdate', Yii::$app->controller->id))){
                    //     throw new \yii\web\HttpException('403',"You don't have permission to access on this role.");
                    // }
                    if (isset($inputall['keylist']) && $inputall['keylist']) {
                        foreach ($inputall['keylist'] as $id) {
                            $model = $this->findModel($id);
                            $model->is_active = '1';
                            $model->is_active_at = currentDateTime();
                            $model->save();
                        }
                    }
                } elseif ($inputall['applyoption'] == self::INACTIVE) {
                    // if(empty(Yii::$app->BackFunctions->checkaccess('statusupdate', Yii::$app->controller->id))){
                    //     throw new \yii\web\HttpException('403',"You don't have permission to access on this role.");
                    // }
                    if (isset($inputall['keylist']) && $inputall['keylist']) {
                        foreach ($inputall['keylist'] as $id) {
                            $model = $this->findModel($id);
                            $model->is_active = '0';
                            $model->is_active_at = currentDateTime();
                            $model->save();
                        }
                    }
                } elseif ($inputall['applyoption'] == self::DELETE) {
                    // if(empty(Yii::$app->BackFunctions->checkaccess('delete', Yii::$app->controller->id))){
                    //     throw new \yii\web\HttpException('403',"You don't have permission to access on this role.");
                    // }

                    if (isset($inputall['keylist']) && $inputall['keylist']) {
                        foreach ($inputall['keylist'] as $id) {
                            Admin::where('id', $id)->delete();
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        }
    }
    protected function findModel($id)
    {
        if (($model = Admin::find($id)) !== null) {
            return $model;
        }
        throw new UnsecureException('The requested page does not exist.');
    }
}
