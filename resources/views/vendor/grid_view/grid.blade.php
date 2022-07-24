<?php
// echo '<pre>'; print_r($toolbar); echo '<pre>';dd();
?>
@php
/** @var \Itstructure\GridView\Columns\BaseColumn[] $columnObjects */
/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
/** @var boolean $useFilters */
$checkboxesExist = false;
@endphp
<style>
    .table-bordered tfoot tr td {
        border-width: 0;
    }
</style>
@php
$resetbtnOption = 'class="btn btn-warning"';
$searchbtnOption = 'class="btn btn-primary"';
if(isset($toolbar['resetbtn']) && $toolbar['resetbtn']){
    $keys = array_keys($toolbar['resetbtn']);
    $values = array_values($toolbar['resetbtn']);
    $attribute = [];
    for($i=0; $i<count($keys); $i++){
        $attribute[] = $keys[$i].'="'.$values[$i].'"';
    }
    $resetbtnOption = ($attribute) ? implode(' ', $attribute) : '';
}

if(isset($toolbar['searchbtn']) && $toolbar['searchbtn']){
    $keys = array_keys($toolbar['searchbtn']);
    $values = array_values($toolbar['searchbtn']);
    $attribute = [];
    for($i=0; $i<count($keys); $i++){
        $attribute[] = $keys[$i].'="'.$values[$i].'"';
    }
    $searchbtnOption = ($attribute) ? implode(' ', $attribute) : '';
}
@endphp
<div id="gridtable-pjax" data-pjax-container="" data-pjax-push-state data-pjax-timeout="1000">
    <div class="kv-loader-overlay"><div class="kv-loader"></div></div>
    <div class="{!! $id !!}" class="grid-view is-bs4 kv-grid-bs4 hide-resize" >
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="float-end">
                    @if ($paginator->onFirstPage())
                    {!! trans('grid_view::grid.page-info', [
                    'start' => '<b>1</b>',
                    'end' => '<b>' . $paginator->perPage() . '</b>',
                    'total' => '<b>' . $paginator->total() . '</b>',
                    ]) !!}
                    @elseif ($paginator->currentPage() == $paginator->lastPage())
                    {!! trans('grid_view::grid.page-info', [
                    'start' => '<b>' . (($paginator->currentPage() - 1) * $paginator->perPage() + 1) . '</b>',
                    'end' => '<b>' . $paginator->total() . '</b>',
                    'total' => '<b>' . $paginator->total() . '</b>',
                    ]) !!}
                    @else
                    {!! trans('grid_view::grid.page-info', [
                    'start' => '<b>' . (($paginator->currentPage() - 1) * $paginator->perPage() + 1) . '</b>',
                    'end' => '<b>' . (($paginator->currentPage()) * $paginator->perPage()) . '</b>',
                    'total' => '<b>' . $paginator->total() . '</b>',
                    ]) !!}
                    @endif
                </div>
                @if($title)
                <h5 class="m-0">{!! $title !!}</h5>
                @endif
            </div>
            <div class="kv-panel-before">
                <div class="btn-toolbar kv-grid-toolbar toolbar-container float-end">
                    @isset($toolbar['content'])
                        @php
                        echo $toolbar['content'];
                        @endphp
                    @endisset
                    @if ($useFilters)
                    <div class="btn-group" role="group">
                        @if(isset($toolbar['resetbtn']) && $toolbar['resetbtn'])
                            <button id="grid_view_reset_button" type="button" @php echo $resetbtnOption @endphp>{{
                                $resetButtonLabel }}</button>
                        @endif
                        {{-- <button id="grid_view_search_button" type="button" @php echo $searchbtnOption @endphp>{{
                            $searchButtonLabel }} <i class="fas fa-filter"></i></button> --}}
                    </div>
                    @endif
                </div>
            </div>
            <div class="">
                <div class="table-responsive kv-grid-container" id="{!! $id !!}-container">
                    <table
                        class="kv-grid-table table @if($tableBordered) table-bordered @endif @if($tableStriped) table-striped @endif @if($tableHover) table-hover @endif @if($tableSmall) table-sm @endif">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                @foreach($columnObjects as $column_obj)
                                <th {!! $column_obj->buildHtmlAttributes() !!}>

                                    @if($column_obj->getSort() === false || $column_obj instanceof
                                    \Itstructure\GridView\Columns\ActionColumn)
                                    {{ $column_obj->getLabel() }}

                                    @elseif($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                    @php($checkboxesExist = true)
                                    @if($useFilters)
                                    {{ $column_obj->getLabel() }}
                                    @else
                                    <input type="checkbox" id="grid_view_checkbox_main" class="form-check-input kv-all-select"
                                        @if($paginator->count() == 0) disabled="disabled" @endif />
                                    @endif

                                    @else
                                    <a
                                        href="{{ \Itstructure\GridView\Helpers\SortHelper::getSortableLink(request(), $column_obj) }}">{{
                                        $column_obj->getLabel() }}</a>
                                    @endif

                                </th>
                                @endforeach
                            </tr>
                            @if ($useFilters)
                            <tr class="filter-header" id="gridtablefilter">
                                <form action="{!! $filterUrl !!}" method="get" id="grid_view_filters_form" data-trigger-pjax="1" >
                                    <td></td>
                                    @foreach($columnObjects as $column_obj)
                                        <td>
                                            @if($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                            <div class="text-center">
                                            <input type="checkbox" id="grid_view_checkbox_main" class="form-check-input kv-all-select"
                                                @if($paginator->count() == 0) disabled="disabled" @endif />
                                            </div>
                                            @else
                                            {!! $column_obj->getFilter()->render() !!}
                                            @endif
                                        </td>
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-primary grid-filter-button d-none"  id="grid-filter-button" form="grid_view_filters_form" title="filter data">Filter&nbsp;<i class="fas fa-filter"></i></button>
                                </form>
                            </tr>
                            @endif
                        </thead>

                        <form action="{{ $rowsFormAction }}" method="post" id="grid_view_rows_form">
                            <tbody>
                                @if($paginator->items())
                                    @foreach($paginator->items() as $key => $row)
                                    <tr class="gridtable">
                                        <td class="text-center">{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $key + 1 }}</td>
                                        @foreach($columnObjects as $column_obj)
                                        @if($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                        <td class="kv-row-select text-center">{!! $column_obj->render($row) !!}</td>
                                        @else
                                        <td class="">{!! $column_obj->render($row) !!}</td>
                                        @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                @else
                                    <tr class=""><td class="text-center" colspan="100">No record found.</td></tr>
                                @endif
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <td colspan="{{ count($columnObjects) + 1 }}">
                                        <div class="mx-1">
                                            <div class="row">
                                                <div class="col-12 col-xl-4 text-center text-xl-start d-flex">
                                                    @if(isset($toolbar['applybtn']))
                                                        {!! $toolbar['applybtn'] !!}
                                                    @elseif (($checkboxesExist || $useSendButtonAnyway) && $paginator->count() > 0)
                                                            <button type="submit" class="btn btn-danger">{{ $sendButtonLabel }}</button>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-xl-12 text-center">
                                                    {{ $paginator->render('grid_view::pagination') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot> --}}
                            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                        </form>
                    </table>
                </div>
            </div>
            <div class="kv-panel-after p-3">
                <div class="row">
                    <div class="col-12 col-xl-4 text-center text-xl-start d-flex">
                        @if(isset($toolbar['applybtn']))
                            {!! $toolbar['applybtn'] !!}
                        @elseif (($checkboxesExist || $useSendButtonAnyway) && $paginator->count() > 0)
                                <button type="submit" class="btn btn-danger">{{ $sendButtonLabel }}</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">    
                <div class="kv-panel-pager text-center">
                    {{ $paginator->render('grid_view::pagination') }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        $('#grid_view_checkbox_main').click(function (event) {
            $('input[role="grid-view-checkbox-item"]').prop('checked', event.target.checked);
        });
        $('#grid_view_search_button').click(function () {
            $('#grid_view_filters_form').submit();
        });

        $('#grid_view_reset_button').click(function () {
            $('input[role="grid-view-filter-item"]').val('');
            $('select[role="grid-view-filter-item"]').prop('selectedIndex', 0);
        });
    });
</script>
@push('grid_js')
    <script>
      (function($) {
        var grid = "#gridtable-pjax";
        var filterForm = "#grid_view_filters_form";
        var searchForm = "";
        _grids.grid.init({
          id: grid,
          filterForm: filterForm,
          dateRangeSelector: '.date-range',
        //   searchForm: searchForm,
          pjax: {
            pjaxOptions: {
              scrollTo: false,
            },
            // what to do after a PJAX request. Js plugins have to be re-intialized
            afterPjax: function(e) {
              _grids.init();
            },
          },
        });
      })(jQuery);
    </script>
@endpush
