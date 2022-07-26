<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UnsecureException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleAccessRequest;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Route;

class RoleController extends Controller
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
        if ($sort) {
            $dataProvider = new EloquentDataProvider(Role::query());
        } else {
            $dataProvider = new EloquentDataProvider(Role::query()->orderBy('id', 'desc'));
        }
        return view('admin.role.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function create()
    {
        $model = new Role();
        return view('admin.role.create', ['model' => $model]);
    }

    public function store(RoleRequest $request)
    {
        $requestAll = $request->all();
        $requestAll['controller'] = $requestAll['controller'] ?? '';
        $requestAll['action'] = $requestAll['action'] ?? '';
        $requestAll['is_active_at'] = currentDateTime();
        $model = new Role();
        if ($request->ajax() && $model->create($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.role.index');
    }

    public function edit($id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.role.update', ['model' => $model]);
    }

    public function update(RoleRequest $request, $id)
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
        return redirect()->route('admin.role.index');
    }

    public function view(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.role.view', ['model' => $model]);
    }

    public function delete(Request $request, $id)
    {
        Role::where('id', decode($id))->delete();
        return redirect()->route('admin.role.index');
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
                            Role::where('id', $id)->delete();
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        }
    }

    public function access(Request $request, $id)
    {
        $rolemodel = $this->findModel(decode($id));
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect(); //important as the existing connection if any would be in strict mode
        $permissionmodel = DB::select("SELECT CASE WHEN ROW_NUMBER() OVER(PARTITION BY module_id ORDER BY id) = 1 THEN (select title as module_name from modules WHERE id = module_id) ELSE NULL END AS 'module_name_unique' , id , module_id , name , title , controller , action FROM permission ORDER BY module_id, controller, id;");
        config()->set('database.connections.mysql.strict', true);
        DB::reconnect();
        $model = new RoleAccess();
        $model->role_id = $id;
        return view('admin.role.access', [
            'model' => $model,
            'rolemodel' => $rolemodel,
            'permissionmodel' => $permissionmodel,
        ]);
    }

    public function accessupdate(RoleAccessRequest $request, $id)
    {
        $id = decode($id);
        $requestAll = $request->all();
        $permission_id = isset($requestAll['permission_id']) ? $requestAll['permission_id'] : [];
        $access = isset($requestAll['access']) ? $requestAll['access'] : [];
        if ($permission_id) {
            foreach ($permission_id as $key => $value) {
                $checkPermissionId = Permission::where(['id' => $value])->count();
                if ($checkPermissionId) {
                    $model = RoleAccess::where(['role_id' => $id, 'permission_id' => $value])->first();
                    if (empty($model)) {
                        $model = new RoleAccess();
                    }
                    $model->role_id = $id;
                    $model->permission_id = $value;
                    $model->access = (isset($access[$key]) && $access[$key]) ? $access[$key] : '0';
                    $model->save();
                }
            }
        }
        return redirect()->route('admin.role.index');
    }
    protected function findModel($id)
    {
        if (($model = Role::find($id)) !== null) {
            return $model;
        }
        throw new UnsecureException('The requested page does not exist.');
    }
}
