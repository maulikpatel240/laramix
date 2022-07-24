@php
    $title_single = 'setting';
    $unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
    $formName = $title_single.'form';
    $formRoute = (!$model->id) ? route('admin.settings.store') : route('admin.settings.update', ['id' => encode($model->id)]);
    $stype = [
        'Text' => 'Text',
        'Textarea' => 'Textarea',
        'File' => 'File',
        'Date' => 'Date',
        'Time' => 'Time',
        'Datetime' => 'Datetime',
        'Radio' => 'Radio',
        'Checkbox' => 'Checkbox',
        'Select' => 'Select',
        'Other' => 'Other'
];
$ajaxurl = route('admin.settings.create');
$description = [];
if($model->id){
    $ajaxurl = route('admin.settings.edit', encode($model->id));
    $description = ($model->description) ? json_decode($model->description, true) : '';
}
$description_placeholder = '';
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
        {{ Form::label('type'); }}
        {{ Form::select('type', $stype, $type, [
        "class" => "form-select",
        'id'=> $formName.'-type',
        'placeholder'=> '--Select--',
        'onchange' => 'typeofvalue($(this).val());'
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('name'); }}
        {{ Form::text('name', $model->name, [
        "class" => "form-control",
        'id'=> $formName.'-name',
        'placeholder'=> '',
        ]) }}
    </div>
    <div class="mb-3">
        {{ Form::label('value'); }}
        @php
            $value = '';
            if($type == 'Text'){
                $value = Form::text('value', $model->value, [
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '',
                        ]);
            }
            if($type == 'Textarea'){
                $value = Form::textArea('value', $model->value, [
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '',
                        'rows' => 3
                        ]);
            }
            if($type == 'File'){
                $image_upload_wrap_div = ($model->value) ? 'display: none;' : 'display: block;';
                $file_upload_content_div = ($model->value) ? 'display: block;' : 'display: none;';
                $image_name = ($model->value) ? $model->value : 'Uploaded Image';
                $value = Form::file('value', [
                    'id'=> $formName.'-logo',
                    'accept'=>"image/*"
                ]);
            }
            if($type == 'Date'){
                $value = Form::text('value', $model->value, [
                        "type" => "date",
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '1970-12-01',
                        ]);
            }
            if($type == 'Time'){
                $value = Form::text('value', $model->value, [
                        "type" => "time",
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '24:00',
                        ]);
            }
            if($type == 'Datetime'){
                $value = Form::text('value', $model->value, [
                    "type" => "text",
                    "class" => "form-control",
                    'id'=> $formName.'-value',
                    'placeholder'=> '1970-12-01 24:00',
                    ]);
            }
            if($type == 'Radio'){
                $description_placeholder = '{"a1":"b1","a2":"b2"}';
                $value = Form::text('value', $model->value, [
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '',
                        ]);
            }
            if($type == 'Checkbox'){
                $description_placeholder = '{"a1":"b1","a2":"b2"}';
                $value = Form::text('value', $model->value, [
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '',
                        ]);
            }
            if($type == 'Select'){
                $description_placeholder = '{"a1":"b1","a2":"b2"}';
                $value = Form::text('value', $model->value, [
                        "class" => "form-control",
                        'id'=> $formName.'-value',
                        'placeholder'=> '',
                        ]);
            }
        @endphp
        {!! $value !!}
    </div>
    <div class="mb-3">
        {{ Form::label('description'); }}
        <p>Checkbox, radio and select option descrition data add {!! $description_placeholder !!}</p>
        {{ Form::textArea('description', '', [
        "class" => "form-control",
        'id'=> $formName.'-description',
        'placeholder'=> $description_placeholder,
        'rows'=> 3,
        ]) }}
    </div>
    <div class="float-end">
        {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-primary',
            'id' => $formName.'-submit']); }}
        {{ Form::button('Close', ['type'=>'button','class' => 'btn btn-secondary',
            'id' => $formName.'-close', 'data-bs-dismiss' => 'modal']); }}
    </div>
    {{ Form::close() }}

    {!! JsValidator::formRequest('App\Http\Requests\Admin\SettingRequest', '#gridview-form'); !!}
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
            $('#settingform-business_phone_number').inputmask({mask: "999-999-9999"});
            // $(":input").inputmask();
            // Inputmask().mask(document.querySelectorAll("input"));
        });

        function typeofvalue(e) {
            //$(".setting_type").html(response);
            var data = {
                type:e
            }
            $.ajax({
                url: "{!! $ajaxurl !!}",
                method: 'post',
                data: data,
                success: function (response) {
                    $('#gridviewModal').find('#modalContent').html(response);
                }});
        }
    </script>