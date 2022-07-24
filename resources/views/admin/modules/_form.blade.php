@php
    $title_single = 'module';
    $unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
    $formName = $title_single.'form';
    $formRoute = (!$model->id) ? route('admin.modules.store') : route('admin.modules.update', ['id' => encode($model->id)]);
    $childmenu = route('admin.modules.childmenu', ['type_id' => $model->type, 'parent_menu_id' => $model->parent_menu_id]);
@endphp
{{ Form::open([
    'url' => $formRoute,
    'class'=>'',
    'id' => 'gridview-form',
    'name' => $formName,
    'modal' => 1,
    'loader' => $unique_title,
    'enableAjaxSubmit' => 1]) }}
    <div id="formerror" class="formerror"></div>
    <div class="mb-3">
        {{ Form::label('panel'); }}
        {{ Form::select('panel', ['Backend' => 'Backend', 'Frontend' => 'Frontend', 'Common' => 'Common'], $model->panel, [
        "class" => "form-select",
        'id'=> $formName.'-panel',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('title'); }}
        {{ Form::text('title', $model->title, [
        "class" => "form-control",
        'id'=> $formName.'-title',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('icon'); }}
        {{ Form::text('icon', $model->icon, [
        "class" => "form-control",
        'id'=> $formName.'-icon',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('controller'); }}
        {{ Form::text('controller', $model->controller, [
        "class" => "form-control",
        'id'=> $formName.'-controller',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('action'); }}
        {{ Form::text('action', $model->action, [
        "class" => "form-control",
        'id'=> $formName.'-action',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('functionality'); }}
        {{ Form::select('functionality', ['crud' => 'Crud', 'singleview' => 'Singleview', 'other' => 'Other', 'none' => 'None'], $model->functionality, [
        "class" => "form-select",
        'id'=> $formName.'-functionality',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('type'); }}
        {{ Form::select('type', ['Menu' => 'Menu', 'Submenu' => 'Submenu', 'Subsubmenu' => 'Subsubmenu'], $model->type, [
        "class" => "form-select",
        'id'=> $formName.'-type',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('parent_menu_id'); }}
        {{ Form::select('parent_menu_id', ['' => '--Select'], $model->parent_menu_id, [
        "class" => "form-select",
        'id'=> $formName.'-parent_menu_id',
        'placeholder'=> '',
         'data-url' => $childmenu 
        ]) }}
    </div>
    <div class="float-end">
        {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-primary',
            'id' => $formName.'-submit']); }}
        {{ Form::button('Close', ['type'=>'button','class' => 'btn btn-secondary',
            'id' => $formName.'-close', 'data-bs-dismiss' => 'modal']); }}
    </div>
    {{ Form::close() }}

    {!! JsValidator::formRequest('App\Http\Requests\Admin\ModuleRequest', '#gridview-form'); !!}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       $('#moduleform-type').depdrop('init');
        $('#moduleform-parent_menu_id').depdrop({
            depends: ['moduleform-type'],
            url: '{!! $childmenu !!}',
            initDepends: ['moduleform-type'], // initial ajax loading will be fired first for parent-1, then child-1, and child-2
            initialize: true,
        });
    </script>