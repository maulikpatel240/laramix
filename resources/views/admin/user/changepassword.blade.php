@php
$title_single = 'ChangePassword';
$unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
$formName = $title_single . 'form';
$formRoute = route('admin.user.changepasswordupdate', ['id' => encode($model->id)]);
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
    {{ Form::label('password') }}
    {{ Form::text('password', '', [
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
<div class="float-end">
      {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-primary',
          'id' => $formName.'-submit']); }}
      {{ Form::button('Close', ['type'=>'button','class' => 'btn btn-secondary',
          'id' => $formName.'-close', 'data-bs-dismiss' => 'modal']); }}
  </div>
{{ Form::close() }}

{!! JsValidator::formRequest('App\Http\Requests\Admin\ChangePasswordRequest', '#gridview-form') !!}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
