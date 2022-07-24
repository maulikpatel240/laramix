@extends('layouts.main')
@php
    use App\Models\RoleAccess;
    $title = 'Access';
    $title_single = 'Access';
    $unique_title = str_replace(' ', '_', strtolower($title_single)); //without space
    $formName = $title_single.'form';
    $formRoute = route('admin.role.accessupdate', ['id' => encode($rolemodel->id)]);
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
<div class="row">
  <div class="col-12">
    {{ Form::open([
      'url' => $formRoute,
      'class'=>'',
      'id' => 'gridview-form',
      'name' => $formName,
      'modal' => 1,
      'loader' => $unique_title,
      'enableAjaxSubmit' => 1]) }}
      <div id="formerror" class="formerror"></div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="float-end">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="permissionid" class="custom-control-input "  value="1" aria-invalid="false">
                      <label class="custom-control-label" for="permissionid">Select all</label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="float-start">
                  <h4 class="title">{{ 'Role : ' . $rolemodel->name }}</h4>
              </div>
            </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
            <?php
            if ($permissionmodel) {
                $i = 0;
                foreach ($permissionmodel as $key => $value) {
                    $RoleAccess = RoleAccess::where(['role_id' => $rolemodel->id, 'permission_id' => $value->id])->first();
                    if ($RoleAccess) {
                        $model->access = $RoleAccess->access;
                    }
                    if ($value->module_name_unique) {
                        ?>
                        <div class="col-sm-12 col-md-12 col-lg-12 bg-light p-2 mt-2">
                            <div class="float-start"><h5 class="font-weight-bold">Access Control : {{ $value->module_name_unique }}</h5></div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-sm-12 col-md-3 col-lg-3 mt-2 mb-2">
                        <div class="d-none">
                          {{ Form::hidden('permission_id[' . $i . ']', $value->id, [
                            "class" => "form-control",
                            'placeholder'=> '',
                            ]) }}
                        </div>
                        {{ Form::checkbox('access[' . $i . ']', '1', $model->access, ['id' => 'roleaccess-access-' . $i,'class'=>"custom-control-input checkbox"]) }}
                        {{ Form::label('roleaccess-access-' . $i, $value->title) }}
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
      </div>
      <div class="card-footer text-center">
              {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-success',
                  'id' => $formName.'-submit']); }}
              {{ link_to_route('admin.role.index', 'Cancel', $parameters = [], ['class' => 'btn btn-danger', 'id' => $formName.'-close']) }}

      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
@endsection

@section('pagescript')
{!! JsValidator::formRequest('App\Http\Requests\Admin\RoleAccessRequest', '#my-form'); !!}
<script>
  $("#permissionid").click(function () {
      $(".checkbox").prop("checked", $(this).prop("checked"));
  });
  var total_checkbox = $(".checkbox").length;
  $(".checkbox").click(function () {
      if (!$(this).prop("checked")) {
          $("#permissionid").prop("checked", false);
      }else{
          var selected = [];
          $(".checkbox:checked").each(function() {
              selected.push($(this).val());
          });
          if(total_checkbox == selected.length){
              $("#permissionid").prop("checked", true);
          }
      }
  });
</script>
@endsection
