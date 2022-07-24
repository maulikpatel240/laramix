@php
/** @var string $field */
/** @var mixed $value */
@endphp
    <input type="checkbox" class="form-check-input kv-row-checkbox" name="{{ $field }}[]" value="{{ $value }}" role="grid-view-checkbox-item"  onchange="$(this).is(':checked') ? $(this).closest('.gridtable').addClass('table-danger') : $(this).closest('.gridtable').removeClass('table-danger');" />
