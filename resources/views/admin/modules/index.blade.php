@extends('layouts.main')
@php
$title = 'Modules';
$title_single = 'Module';
$unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
$createbtn = '';
if (!empty(checkaccess('create', getControllerName()))) {
    $createbtn = '<a href="' . route('admin.modules.create') . '" class="btn btn-primary showModalButton" title="Add ' . $title_single . '" data-bs-toggle="modal" data-bs-target="#gridviewModal">Add</a>';
}
//Apply dropdwon status, delete
$applydropdwon = '';
if (!empty(checkaccess('isactive', getControllerName())) && !empty(checkaccess('delete', getControllerName()))) {
    $applydropdown = '<select class="form-select w-auto me-3" name="applyoption" id="applyoption">
            <option value="">--Select--</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Delete">Delete</option>
            </select>';
} elseif (!empty(checkaccess('isactive', getControllerName())) && empty(checkaccess('delete', getControllerName()))) {
    $applydropdown = '<select class="form-select w-auto me-3" name="applyoption" id="applyoption">
            <option value="">--Select--</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            </select>';
} elseif (empty(checkaccess('isactive', getControllerName())) && !empty(checkaccess('delete', getControllerName()))) {
    $applydropdown = '<select class="form-select w-auto me-3" name="applyoption" id="applyoption">
            <option value="">--Select--</option>
            <option value="Delete">Delete</option>
            </select>';
}
$applyafter = '';
if (!empty(checkaccess('isactive', getControllerName())) || !empty(checkaccess('delete', getControllerName()))) {
    $applySubmit = Form::button('Apply', ['class' => 'btn btn-primary', 'id' => 'applysubmit', 'onclick' => 'applyjs(this);']);
    $applyafter = $applydropdown . ' ' . $applySubmit;
}

$actionTypes = [];
if (!empty(checkaccess('view', getControllerName()))) {
    $actionTypes[] = [
        'class' => Itstructure\GridView\Actions\View::class, // Required
        'url' => function ($model) {
            // Optional
            return route('admin.modules.view', ['id' => encode($model->id)]);
        },
        'htmlAttributes' => [
            // Optional
            'class' => 'showModalButton text-warning ms-1 me-1',
            'title' => 'View ' . $title_single,
        ],
    ];
}
if (!empty(checkaccess('update', getControllerName()))) {
    $actionTypes[] = [
        'class' => Itstructure\GridView\Actions\Edit::class, // Required
        'url' => function ($model) {
            // Optional
            return route('admin.modules.edit', ['id' => encode($model->id)]);
        },
        'htmlAttributes' => [
            // Optional
            'class' => 'showModalButton text-primary ms-1 me-1',
            'title' => 'Update ' . $title_single,
        ],
    ];
}
if (!empty(checkaccess('delete', getControllerName()))) {
    $actionTypes[] = [
        'class' => Itstructure\GridView\Actions\Delete::class, // Required
        'url' => function ($model) {
            // Optional
            return route('admin.modules.delete', ['id' => encode($model->id)]);
        },
        'htmlAttributes' => [
            // Optional
            'title' => 'Delete ' . $title_single,
            'class' => 'text-danger ms-1 me-1',
            'onclick' => 'return window.confirm("Are you sure you want to delete?");',
        ],
    ];
}
@endphp
@section('title')
    {{ $title }}
@endsection
@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    @php
    $gridData = [
        'id' => 'gridtable',
        'dataProvider' => $dataProvider,
        'useFilters' => true,
        'filterUrl' => url()->current(),
        'paginatorOptions' => [
            // Here you can set some options of paginator Illuminate\Pagination\LengthAwarePaginator, used in a package.
            'pageName' => 'p',
        ],
        'pjax' => true,
        'rowsPerPage' => config('params.rowsPerPage'), // The number of rows in one page. By default 10.
        'title' => 'List', // It can be empty ''
        'strictFilters' => false, // If true, then a searching by filters will be strict, using an equal '=' SQL operator instead of 'like'.
        'rowsFormAction' => route('admin.modules.applystatus'), // Route url to send slected checkbox items for deleting rows, for example.
        'useSendButtonAnyway' => false, // If true, even if there are no checkbox column, the main send button will be displayed.
        'columnFields' => [
            [
                'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                'field' => 'delete',
                'attribute' => 'id',
            ],
            [
                'label' => 'Title', // Column label.
                'attribute' => 'title', // Attribute, by which the row column data will be taken from a model.
            ],
            [
                'label' => 'Type',
                'attribute' => 'type',
                'value' => function ($row) {
                    return $row->type;
                },
                'sort' => 'type', // To sort rows. Have to set if an 'attribute' is not defined for column.
            ],
            [
                'label' => 'Functionality', // Column label.
                'attribute' => 'functionality', // Attribute, by which the row column data will be taken from a model.
            ],
            [
                'label' => 'Panel', // Column label.
                'attribute' => 'panel', // Attribute, by which the row column data will be taken from a model.
                'filter' => [
                    // For dropdown it is necessary to set 'data' array. Array keys are for html <option> tag values, array values are for titles.
                    'class' => Itstructure\GridView\Filters\DropdownFilter::class, // REQUIRED. For this case it is necessary to set 'class'.
                    'name' => 'panel', // REQUIRED if 'attribute' is not defined for column.
                    'data' => [
                        // REQUIRED.
                        'Backend' => 'Backend',
                        'Frontend' => 'Frontend',
                        'Common' => 'Common',
                    ],
                ],
            ],
            [
                'label' => 'Active', // Column label.
                'value' => function ($model) {
                    // You can set 'value' as a callback function to get a row data value dynamically.
                    $btnbg = $model->is_active == 1 ? 'success' : 'danger';
                    $active = $model->is_active == 1 ? 'Active' : 'Inactive';
                    if (!empty(checkaccess('isactive', getControllerName()))) {
                        return Html::link('javascript:void(0)', $active, [
                            'class' => 'btn btn-' . $btnbg . ' btn-sm',
                            'id' => 'is_active_' . $model->id,
                            'title' => $active,
                            'onclick' =>
                                '$.post({
                                url: "' .route('admin.modules.isactive', ['id' => encode($model->id)]) .'",
                                    success: function (response) {
                                    $.pjax.reload({container: "#gridtable-pjax"});
                                    },
                                }); return false;',
                        ]);
                    } else {
                        return '<span class="btn btn-' . $btnbg . ' btn-sm cursor-auto">'.$active.'</span>';
                    }
                },
                'filter' => [
                    // For dropdown it is necessary to set 'data' array. Array keys are for html <option> tag values, array values are for titles.
                    'class' => Itstructure\GridView\Filters\DropdownFilter::class, // REQUIRED. For this case it is necessary to set 'class'.
                    'name' => 'is_active', // REQUIRED if 'attribute' is not defined for column.
                    'data' => [
                        // REQUIRED.
                        0 => 'Inactive',
                        1 => 'Active',
                    ],
                ],
                'format' => 'html', // To render column content without lossless of html tags, set 'html' formatter.
                'sort' => 'is_active', // To sort rows. Have to set if an attribute is not defined for column.
            ],
            [
                'label' => 'Actions', // Optional
                'class' => Itstructure\GridView\Columns\ActionColumn::class, // Required
                'actionTypes' => $actionTypes,
            ],
        ],
        // set your toolbar
        'toolbar' => [
            'content' =>
                '<div class="btn-group" role="group">
                    ' .$createbtn .'
                    <a href="' .route('admin.modules.index') .'" class="btn btn-secondary" title="Refresh Module" data-trigger-pjax="1" ><i class="fas fa-redo"></i></a>
                </div>', 
            'resetbtn' => false,
            'applybtn' => $applyafter,
        ],
    ];
    @endphp
    @gridView($gridData)
@endsection

@section('modal')
    {!! Modal::start([
    'options' => ['id' => 'gridviewModal'],
    'title' => 'Create Module',
    'header' => true,
    'size' => 'modal-md',
    'clientOptions' => [
        'backdrop' => true,
        'keyboard' => true,
    ],
]) !!}
    @include('layouts.loadercontent', ['name' => $unique_title, 'loader' => 'div'])
    <div id="modalContent"></div>
    {!! Modal::end() !!}
@endsection

@section('pagescript')
    <script>
        var nameloader = '.{!! $unique_title !!}_loader';
        $(document).on('click', '.showModalButton', function() {
            document.getElementById('gridviewModal-label').innerHTML = $(this).attr('title');
            var data = {
                "_token": "{{ csrf_token() }}",
            }
            $.ajax({
                type: 'POST',
                url: $(this).attr('href'),
                data: data,
                beforeSend: function() {
                    $('#gridviewModal').modal('show');
                    $('#gridviewModal').find('#modalContent').html('');
                    $(nameloader).show();
                },
                success: function(response) {
                    $('#gridviewModal').find('#modalContent').html(response);
                },
                complete: function() {
                    $(nameloader).hide();
                }
            });
            return false;
        });

        function applyjs(e) {
            var confirmbtn = confirmationAlert(
                e,
                "Are you sure want to Apply?",
                "text"
            );
            if (confirmbtn == true) {
                var keys = [];
                $('.kv-grid-table').find("input[name='delete[]']:checked").each(function() {
                    keys.push($(this).val());
                });
                // var myform = document.getElementById("grid_view_rows_form");
                // var fd = new FormData(myform);
                var applyoption = $("#applyoption").val();
                $.post({
                    url: $("#grid_view_rows_form").attr("action"),
                    data: {
                        keylist: keys,
                        applyoption: applyoption
                    },
                    // processData: false,
                    // contentType: false,
                    success: function(response) {
                        //alert('I did it! Processed checked rows.')
                        $.pjax.reload({
                            container: "#gridtable-pjax"
                        });
                    },
                });
            }
        }
    </script>
@endsection
