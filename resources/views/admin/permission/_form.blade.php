@php
$title_single = 'permission';
$unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
$formName = $title_single . 'form';
$formRoute = !$model->id ? route('admin.permission.store') : route('admin.permission.update', ['id' => encode($model->id)]);

$defaultPermission = [
    [
        'title' => 'List',
        'name' => 'list',
        'controller' => '',
        'action' => 'index',
    ],
    [
        'title' => 'Create',
        'name' => 'create',
        'controller' => '',
        'action' => 'create',
    ],
    [
        'title' => 'Update',
        'name' => 'update',
        'controller' => '',
        'action' => 'update',
    ],
    [
        'title' => 'View',
        'name' => 'view',
        'controller' => '',
        'action' => 'view',
    ],
    [
        'title' => 'Delete',
        'name' => 'delete',
        'controller' => '',
        'action' => 'delete',
    ],
    [
        'title' => 'Is active',
        'name' => 'isactive',
        'controller' => '',
        'action' => 'isactive',
    ],
    [
        'title' => 'Export',
        'name' => 'export',
        'controller' => '',
        'action' => 'export',
    ]
];

$model->type = 'Backend';
@endphp
{{ Form::open([
    'url' => $formRoute,
    'class' => '',
    'id' => 'gridview-form',
    'name' => $formName,
    'modal' => 1,
    'loader' => $unique_title,
    'enableAjaxSubmit' => 1,
]) }}
<div id="formerror" class="formerror"></div>

<div class="mb-3">
    {{ Form::label('module_id') }}
    {{ Form::select('module_id', $modules, $model->module_id, [
        'class' => 'form-select select2',
        'id' => $formName . '-module_id',
        'placeholder' => '',
    ]) }}
</div>
<div class="mb-3">
    {{ Form::label('panel') }}
    {{ Form::select('panel', ['Backend' => 'Backend', 'Frontend' => 'Frontend', 'App' => 'App', 'Common' => 'Common'], $model->panel, [
        'class' => 'form-select',
        'id' => $formName . '-panel',
        'placeholder' => '',
    ]) }}
</div>
@if ($model->id)
    <div class="mb-3">
        {{ Form::label('controller') }}
        {{ Form::text('controller', $model->controller, [
            'class' => 'form-control',
            'id' => $formName . '-controller',
            'placeholder' => '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('action') }}
        {{ Form::text('action', $model->action, [
            'class' => 'form-control',
            'id' => $formName . '-action',
            'placeholder' => '',
        ]) }}
    </div>
@else
    <table class="table table-sm table-bordered" style="display: block;" id="main-container">
        <thead>
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>Controller</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="addRow">
            @foreach ($defaultPermission as $key => $permission)
                <tr class="container-item">
                    <td>
                        {{ Form::text('title[' . $key . ']', $permission['title'], [
                            'class' => 'form-control',
                            'id' => $formName . '-title' . $key,
                            'placeholder' => '',
                        ]) }}
                    </td>
                    <td>
                        {{ Form::text('name[' . $key . ']', $permission['name'], [
                            'class' => 'form-control',
                            'id' => $formName . '-name' . $key,
                            'placeholder' => '',
                        ]) }}
                    </td>
                    <td>
                        {{ Form::text('controller[' . $key . ']', $permission['controller'], [
                            'class' => 'form-control',
                            'id' => $formName . '-controller' . $key,
                            'placeholder' => '',
                        ]) }}
                    </td>
                    <td>
                        {{ Form::text('action[' . $key . ']', $permission['action'], [
                            'class' => 'form-control',
                            'id' => $formName . '-action' . $key,
                            'placeholder' => '',
                        ]) }}
                    </td>
                    <td>
                        <a href="javascript:void(0)"
                            class="remove-item btn btn-sm btn-danger remove-social-media">Remove</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-end">
                    <div class="mb-3">
                        <a class="btn btn-success btn-sm" id="add-more" href="javascript:;" role="button"><i
                                class="fa fa-plus"></i> Add more address</a>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
@endif
<div class="float-end">
    {{ Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => $formName . '-submit']) }}
    {{ Form::button('Close', ['type' => 'button','class' => 'btn btn-secondary','id' => $formName . '-close','data-bs-dismiss' => 'modal']) }}
</div>
{{ Form::close() }}

{!! JsValidator::formRequest('App\Http\Requests\Admin\PermissionRequest', '#gridview-form') !!}

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('a#add-more').cloneData({
        mainContainerId: 'main-container', // Main container Should be ID
        cloneContainer: 'container-item', // Which you want to clone
        removeButtonClass: 'remove-item', // Remove button for remove cloned HTML
        removeConfirm: false, // default true confirm before delete clone item
        removeConfirmMessage: 'Are you sure want to delete?', // confirm delete message
        //append: '<a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media">Remove</a>', // Set extra HTML append to clone HTML
        minLimit: 1, // Default 1 set minimum clone HTML required
        // maxLimit: 5, // Default unlimited or set maximum limit of clone HTML
        defaultRender: 1,
        init: function() {
            $(".select2").select2({
                placeholder: '--Select--',
                allowClear: true,
                dropdownParent: $("#gridviewModal"),
                width: "100%",
            });
            console.info(':: Initialize Plugin ::');
        },
        beforeRender: function() {
            console.info(':: Before rendered callback called');
        },
        afterRender: function() {
            console.info(':: After rendered callback called');
            //$(".selectpicker").selectpicker('refresh');
        },
        afterRemove: function() {
            console.warn(':: After remove callback called');
        },
        beforeRemove: function() {
            console.warn(':: Before remove callback called');
        }
    });
    $(".select2").select2({
        placeholder: '--Select--',
        allowClear: true,
        dropdownParent: $("#gridviewModal"),
        width: "100%",
    });
</script>
