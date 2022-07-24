<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UnsecureException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class SettingsController extends Controller
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
            $dataProvider = new EloquentDataProvider(Settings::query());
        } else {
            $dataProvider = new EloquentDataProvider(Settings::query()->orderBy('id', 'desc'));
        }
        return view('admin.settings.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function create(Request $request)
    {
        $model = new Settings();
        $type = ($request->type) ? $request->type : $model->type;
        $model->type = $type;
        return view('admin.settings.create', ['model' => $model, 'type' => $type]);
    }

    public function store(SettingRequest $request)
    {
        $requestAll = $request->all();
        $requestAll['is_active_at'] = currentDateTime();
        $file = $request->file('value');
        if ($file) {
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('settings', $fileName, 'public');
            $requestAll['value'] = $fileName;
        }
        $model = new Settings();
        if ($request->ajax() && $model->create($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.settings.index');
    }

    public function edit(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        $type = $model->type;
        $type = ($request->type) ? $request->type : $type;
        return view('admin.settings.update', ['model' => $model, 'type' => $type]);
    }

    public function update(SettingRequest $request, $id)
    {
        // $validated = $request->validated();
        $requestAll = $request->all();
        $model = $this->findModel(decode($id));
        $file = $request->file('value');
        $requestAll['value'] = $model->value;
        if ($file) {
            Storage::delete('/public/settings/' . $model->logo);
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('settings', $fileName, 'public');
            $requestAll['value'] = $fileName;
        }
        if ($request->ajax() && $model->update($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.settings.index');
    }

    public function view(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.settings.view', ['model' => $model]);
    }

    public function delete(Request $request, $id)
    {
        Settings::where('id', decode($id))->delete();
        return redirect()->route('admin.settings.index');
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
                            Settings::where('id', $id)->delete();
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
        if (($model = Settings::find($id)) !== null) {
            return $model;
        }
        throw new UnsecureException('The requested page does not exist.');
    }
}
