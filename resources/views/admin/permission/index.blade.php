@extends('layouts.main')
@php
    $title = 'Permission';
    $title_single = 'Permission';
    $unique_title = str_replace(' ', '_', strtolower($title_single));; //without space
    $createbtn = '';
    if (!empty(checkaccess('create', getControllerName()))) {
        $createbtn = '<a href="'.route('admin.permission.create').'" class="btn btn-primary showModalButton" title="Add '.$title_single.'" data-bs-toggle="modal" data-bs-target="#gridviewModal">Add</a>';
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
                    'url' => function ($model) { // Optional
                        return route('admin.permission.view', ['id' => encode($model->id)]);
                    },
                    'htmlAttributes' => [ // Optional
                        'class' => 'showModalButton text-warning ms-1 me-1',
                        'title' => 'View '.$title_single,
                    ]
                ];
}
if (!empty(checkaccess('update', getControllerName()))) {
    $actionTypes[] = [
                    'class' => Itstructure\GridView\Actions\Edit::class, // Required
                    'url' => function ($model) { // Optional
                        return route('admin.permission.edit', ['id' => encode($model->id)]);
                    },
                    'htmlAttributes' => [ // Optional
                        'class' => 'showModalButton text-primary ms-1 me-1',
                        'title' => 'Update '.$title_single,
                    ]
                ];
}
if (!empty(checkaccess('delete', getControllerName()))) {
    $actionTypes[] = [
                    'class' => Itstructure\GridView\Actions\Delete::class, // Required
                    'url' => function ($model) { // Optional
                        return route('admin.permission.delete', ['id' => encode($model->id)]);
                    },
                    'htmlAttributes' => [ // Optional
                        'title' => 'Delete '.$title_single,
                        'class' => 'text-danger ms-1 me-1',
                        'onclick' => 'return window.confirm("Are you sure you want to delete?");'
                    ]
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
        'paginatorOptions' => [ // Here you can set some options of paginator Illuminate\Pagination\LengthAwarePaginator, used in a package.
            'pageName' => 'p'
        ],
        'pjax' => true,
        'rowsPerPage' => config('params.rowsPerPage'), // The number of rows in one page. By default 10.
        'title' => 'List', // It can be empty ''
        'strictFilters' => false, // If true, then a searching by filters will be strict, using an equal '=' SQL operator instead of 'like'.
        'rowsFormAction' => route('admin.permission.applystatus'), // Route url to send slected checkbox items for deleting rows, for example.
        'useSendButtonAnyway' => false, // If true, even if there are no checkbox column, the main send button will be displayed.
        'columnFields' => [
                [
                    'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                    'field' => 'delete',
                    'attribute' => 'id'
                ],
                [
                    'label' => 'Title', // Column label.
                    'attribute' => 'title', // Attribute, by which the row column data will be taken from a model.
                ],
                'name',
                'controller',
                'action',
                'panel',
                [
                    'label' => 'Actions', // Optional
                    'class' => Itstructure\GridView\Columns\ActionColumn::class, // Required
                    'actionTypes' => $actionTypes
                ],
            ],
            // set your toolbar
            'toolbar' =>  [
                'content' => '<div class="btn-group" role="group">
                                '.$createbtn.'
                                <a href="'.route("admin.permission.index").'" class="btn btn-secondary" title="Refresh Module" data-trigger-pjax="1" ><i class="fas fa-redo"></i></a>
                            </div>
                            ',
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
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => true,
        'keyboard' => true
    ]
  ]) !!}
 @include('layouts.loadercontent', ['name' => $unique_title, 'loader' => 'div'])
<div id="modalContent"></div>
{!! Modal::end() !!}
@endsection

@section('pagescript')
<script>
    var nameloader = '.{!! $unique_title !!}_loader';
    $(document).on('click', '.showModalButton', function () {
        document.getElementById('gridviewModal-label').innerHTML = $(this).attr('title');
        var data = {
            "_token": "{{ csrf_token() }}",
        }
        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            data: data,
            beforeSend: function () {
                $('#gridviewModal').modal('show');
                $('#gridviewModal').find('#modalContent').html('');
                $(nameloader).show();
            },
            success: function (response) {
                $('#gridviewModal').find('#modalContent').html(response);
            },
            complete: function () {
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
                var keys=[];
                $('.kv-grid-table').find("input[name='delete[]']:checked").each(function () {
                    keys.push($(this).val());
                });
                // var myform = document.getElementById("grid_view_rows_form");
                // var fd = new FormData(myform);
                var applyoption = $("#applyoption").val();
                $.post({
                    url: $("#grid_view_rows_form").attr("action"),
                    data: {keylist: keys, applyoption: applyoption},
                    // processData: false,
                    // contentType: false,
                    success: function(response) {
                        //alert('I did it! Processed checked rows.')
                        $.pjax.reload({ container: "#gridtable-pjax" });
                    },
                });
            }
        }

</script>
@endsection

