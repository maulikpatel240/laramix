<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UnsecureException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustompageRequest;
use App\Models\Custompages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class CustompagesController extends Controller
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
            $dataProvider = new EloquentDataProvider(Custompages::query());
        } else {
            $dataProvider = new EloquentDataProvider(Custompages::query()->orderBy('id', 'desc'));
        }
        return view('admin.custompages.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function create(Request $request)
    {
        $model = new Custompages();
        $type = ($request->type) ? $request->type : $model->type;
        $model->type = $type;
        return view('admin.custompages.create', ['model' => $model, 'type' => $type]);
    }

    public function store(CustompageRequest $request)
    {
        $requestAll = $request->all();
        $requestAll['is_active_at'] = currentDateTime();
        $file = $request->file('value');
        if ($file) {
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('custompages', $fileName, 'public');
            $requestAll['value'] = $fileName;
        }
        $model = new Custompages();
        if ($request->ajax() && $model->create($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.custompages.index');
    }

    public function edit(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        $type = $model->type;
        $type = ($request->type) ? $request->type : $type;
        return view('admin.custompages.update', ['model' => $model, 'type' => $type]);
    }

    public function update(CustompageRequest $request, $id)
    {
        // $validated = $request->validated();
        $requestAll = $request->all();
        $model = $this->findModel(decode($id));
        $file = $request->file('value');
        $requestAll['value'] = $model->value;
        if ($file) {
            Storage::delete('/public/custompages/' . $model->logo);
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('custompages', $fileName, 'public');
            $requestAll['value'] = $fileName;
        }
        if ($request->ajax() && $model->update($requestAll)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = false;
            return response()->json($responseData);
        }
        return redirect()->route('admin.custompages.index');
    }

    public function view(Request $request, $id)
    {
        $model = $this->findModel(decode($id));
        return view('admin.custompages.view', ['model' => $model]);
    }

    public function delete(Request $request, $id)
    {
        Custompages::where('id', decode($id))->delete();
        return redirect()->route('admin.custompages.index');
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
                            Custompages::where('id', $id)->delete();
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
        if (($model = Custompages::find($id)) !== null) {
            return $model;
        }
        throw new UnsecureException('The requested page does not exist.');
    }
}
