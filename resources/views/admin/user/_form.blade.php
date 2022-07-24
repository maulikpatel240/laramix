@php
use App\Models\Role;
$title_single = 'user';
$unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
$formName = $title_single . 'form';

$formRoute = !$model->id ? route('admin.user.store') : route('admin.user.update', ['id' => encode($model->id)]);
$role = Role::where('is_active', '1')
    ->whereIn('id', [2, 4])
    ->get()
    ->pluck('name', 'id')
    ->toArray();
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
    {{ Form::label('role') }}
    {{ Form::select('role_id', $role, $model->role_id, [
        'class' => 'form-select',
        'id' => $formName . '-role_id',
        'placeholder' => '--Select--',
    ]) }}
</div>
<div class="mb-3">

    {{ Form::label('first_name') }}
    {{ Form::text('first_name', $model->first_name, [
        'class' => 'form-control',
        'id' => $formName . '-first_name',
        'placeholder' => '',
    ]) }}
</div>
<div class="mb-3">
    {{ Form::label('last_name') }}
    {{ Form::text('last_name', $model->last_name, [
        'class' => 'form-control',
        'id' => $formName . '-last_name',
        'placeholder' => '',
    ]) }}
</div>
<div class="mb-3">
    {{ Form::label('email') }}
    {{ Form::text('email', $model->email, [
        'class' => 'form-control',
        'id' => $formName . '-email',
        'placeholder' => '',
    ]) }}
</div>
@if (!$model->id)
    <div class="mb-3">
        {{ Form::label('password') }}
        {{ Form::text('password', $model->password, [
            'class' => 'form-control',
            'id' => $formName . '-password',
            'placeholder' => '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('confirm password') }}
        {{ Form::text('confirm_password', '', [
            'class' => 'form-control',
            'id' => $formName . '-confirm_password',
            'placeholder' => '',
        ]) }}
    </div>
@endif
<div class="mb-3">
    {{ Form::label('phone_number') }}
    {{ Form::text('phone_number', $model->phone_number, [
        'class' => 'form-control',
        'id' => $formName . '-phone_number',
        'placeholder' => '',
    ]) }}
</div>
<div class="float-end">
    {{     Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => $formName . '-submit']) }}
    {{     Form::button('Close', ['type' => 'button', 'class' => 'btn btn-secondary', 'id' => $formName . '-close', 'data-bs-dismiss' => 'modal']) }}
</div>
{{ Form::close() }}

{!! JsValidator::formRequest('App\Http\Requests\Admin\UserRequest', '#gridview-form') !!}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#userform-phone_number').inputmask({
            mask: "999-999-9999"
        });
        // $(":input").inputmask();
        // Inputmask().mask(document.querySelectorAll("input"));
    });
    $(".select2").select2({
        placeholder: '--Select--',
        allowClear: true,
        dropdownParent: $("#gridviewModal"),
        width: "100%",
    });
</script>
