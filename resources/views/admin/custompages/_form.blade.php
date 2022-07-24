@php
$title_single = 'Custompage';
$unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
$formName = $title_single . 'form';
$formRoute = !$model->id ? route('admin.custompages.store') : route('admin.custompages.update', ['id' => encode($model->id)]);
global $user;
$readonly = $user->role_id != 1 ? true : false;
@endphp
{{ Form::open([
    'url' => $formRoute,
    'class' => '',
    'id' => 'gridview-form',
    'name' => $formName,
    'modal' => 1,
    'loader' => $unique_title,
    'files' => true,
    'enableAjaxSubmit' => 1,
]) }}
<div id="formerror" class="formerror"></div>
<div class="mb-3">
    {{ Form::label('name') }}
    {{ Form::text('name', $model->name, [
        'class' => 'form-control',
        'id' => $formName . '-name',
        'placeholder' => '',
        'readonly' => $readonly,
    ]) }}
</div>
<div class="mb-3">
    {{ Form::label('title') }}
    {{ Form::text('title', $model->title, [
        'class' => 'form-control',
        'id' => $formName . '-title',
        'placeholder' => '',
        'readonly' => $readonly,
    ]) }}
</div>
<div class="mb-3">
    {{ Form::label('description') }}
    {{ Form::textArea('description', $model->description, [
        'class' => 'form-control',
        'id' => $formName . '-description',
        'placeholder' => '',
    ]) }}
</div>
<div class="float-end">
    {{     Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => $formName . '-submit']) }}
    {{     Form::button('Close', ['type' => 'button', 'class' => 'btn btn-secondary', 'id' => $formName . '-close', 'data-bs-dismiss' => 'modal']) }}
</div>
{{ Form::close() }}

{!! JsValidator::formRequest('App\Http\Requests\Admin\CustompageRequest', '#gridview-form') !!}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".select2").select2({
        placeholder: '--Select--',
        allowClear: true,
        dropdownParent: $("#gridviewModal"),
        width: "100%",
    });
    $(document).ready(function() {
        $('#salonform-business_phone_number').inputmask({
            mask: "999-999-9999"
        });
        $('#Custompageform-description').summernote();
        // $(":input").inputmask();
        // Inputmask().mask(document.querySelectorAll("input"));
    });
</script>
