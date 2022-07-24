@php
    $title_single = 'EmailTemplate';
    $unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
    $formName = $title_single.'form';
    $formRoute = (!$model->id) ? route('admin.emailtemplates.store') : route('admin.emailtemplates.update', ['id' => encode($model->id)]);
@endphp
{{ Form::open([
    'url' => $formRoute,
    'class'=>'',
    'id' => 'gridview-form',
    'name' => $formName,
    'modal' => 1,
    'loader' => $unique_title,
    'files' => true,
    'enableAjaxSubmit' => 1]) }}
    <div id="formerror" class="formerror"></div>
    <div class="mb-3">
        {{ Form::label('code'); }}
        {{ Form::text('code', $model->code, [
        "class" => "form-control",
        'id'=> $formName.'-code',
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
        {{ Form::label('subject'); }}
        {{ Form::text('subject', $model->subject, [
        "class" => "form-control",
        'id'=> $formName.'-subject',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('html'); }}
        {{ Form::textArea('html', $model->html, [
        "class" => "form-control",
        'id'=> $formName.'-html',
        'placeholder'=> ''
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

    {!! JsValidator::formRequest('App\Http\Requests\Admin\EmailtemplateRequest', '#gridview-form'); !!}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".select2").select2({
            placeholder:'--Select--',
            allowClear:true,
            dropdownParent: $("#gridviewModal"),
            width: "100%",
        });
        $(document).ready(function(){
            $('#salonform-business_phone_number').inputmask({mask: "999-999-9999"});
            $('#EmailTemplateform-html').summernote();
            // $(":input").inputmask();
            // Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>
