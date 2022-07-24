<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UnsecureException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModuleRequest;
use App\Models\Modules;
use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class ModulesController extends Controller
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
            $dataProvider = new EloquentDataProvider(Modules::query());
        } else {
            $dataProvider = new EloquentDataProvider(Modules::query()->orderBy('id', 'desc'));
        }
        return view('admin.modules.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function create()
    {
        $model = new Modules();
        return view('admin.modules.create', ['model' => $model]);
    }

    public function store(ModuleRequest $request)
    {
        $requestAll = $request->all();
        $requestAll['controller'] = $requestAll['controller'] ?? '';
        $requestAll['action'] = $requestAll['action'] ?? '';
        $requestAll['is_active_at'] = currentDateTime();
        $model = new Modules();
        if ($request->ajax() && $model->create($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.modules.index');
    }

    public function edit($id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.modules.update', ['model' => $model]);
    }

    public function update(ModuleRequest $request, $id)
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
        return redirect()->route('admin.modules.index');
    }

    public function view(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.modules.view', ['model' => $model]);
    }

    public function delete(Request $request, $id)
    {
        Modules::where('id', decode($id))->delete();
        return redirect()->route('admin.modules.index');
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
                            Modules::where('id', $id)->delete();
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
        if (($model = Modules::find($id)) !== null) {
            return $model;
        }

        throw new UnsecureException('The requested page does not exist.');
    }

    public function childmenu(Request $request)
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {

            $type = empty($_POST['depdrop_parents'][0]) ? null : $_POST['depdrop_parents'][0];
            // $parent_menu_id = empty($_POST['depdrop_parents'][1]) ? null : $_POST['depdrop_parents'][1];
            $type_id = isset($_REQUEST['type_id']) ? $_REQUEST['type_id'] : '';
            $parent_menu_id = isset($_REQUEST['parent_menu_id']) ? $_REQUEST['parent_menu_id'] : '';
            $list = [];
            if ($type == 'Submenu') {
                $list = Modules::where(['parent_submenu_id' => null, 'type' => 'Menu'])->where('title', '!=', '')->get()->pluck('title', 'id')->toArray();
                // $list = Modules::find();
            } elseif ($type == 'Subsubmenu' && ($parent_menu_id == 0 || empty($parent_menu_id))) {
                $list = Modules::where(['parent_menu_id' => 0, 'parent_submenu_id' => 0])->where('title', '!=', '')->get()->pluck('title', 'id')->toArray();
            }
            $selected = null;
            if ($type != null && count($list) > 0) {
                $selected = $parent_menu_id;
                foreach ($list as $key => $value) {
                    $out[] = ['id' => $key, 'name' => $value];
                }
                // Shows how you can preselect a value
                return response()->json(['output' => $out, 'selected' => $selected]);
            }
        }
        return response()->json(['output' => '', 'selected' => '']);
    }

    protected function addPjaxHeaders(Request $request)
    {
        $request->headers->set('X-PJAX', true);
        $request->headers->set('X-PJAX-Container', '#pjax-container');
        return $request;
    }
}
