@php
    $title_single = 'role';
    $unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
    $formName = $title_single.'form';
    $formRoute = (!$model->id) ? route('admin.role.store') : route('admin.role.update', ['id' => encode($model->id)]);
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
        {{ Form::label('name'); }}
        {{ Form::text('name', $model->name, [
        "class" => "form-control",
        'id'=> $formName.'-name',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('panel'); }}
        {{ Form::select('panel', ['Backend' => 'Backend', 'Frontend' => 'Frontend', 'Common' => 'Common'], $model->panel, [
        "class" => "form-select",
        'id'=> $formName.'-panel',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="float-end">
        {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-primary',
            'id' => $formName.'-submit']); }}
        {{ Form::button('Close', ['type'=>'button','class' => 'btn btn-secondary',
            'id' => $formName.'-close', 'data-bs-dismiss' => 'modal']); }}
    </div>
    {{ Form::close() }}

    {!! JsValidator::formRequest('App\Http\Requests\Admin\RoleRequest', '#gridview-form'); !!}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
