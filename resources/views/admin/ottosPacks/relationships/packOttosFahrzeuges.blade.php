@can('ottos_fahrzeuge_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ottos-fahrzeuges.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ottosFahrzeuge.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.ottosFahrzeuge.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-packOttosFahrzeuges">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.kategorie') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.model') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.fahrzeug') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.preis') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.lieferbar') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.justiert') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.im_shop') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosFahrzeuge.fields.pack') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ottosFahrzeuges as $key => $ottosFahrzeuge)
                        <tr data-entry-id="{{ $ottosFahrzeuge->id }}">
                            <td>

                            </td>
                            <td>
                                {{ App\Models\OttosFahrzeuge::KATEGORIE_SELECT[$ottosFahrzeuge->kategorie] ?? '' }}
                            </td>
                            <td>
                                {{ $ottosFahrzeuge->model ?? '' }}
                            </td>
                            <td>
                                {{ $ottosFahrzeuge->fahrzeug ?? '' }}
                            </td>
                            <td>
                                {{ $ottosFahrzeuge->preis ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\OttosFahrzeuge::LIEFERBAR_SELECT[$ottosFahrzeuge->lieferbar] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\OttosFahrzeuge::JUSTIERT_SELECT[$ottosFahrzeuge->justiert] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\OttosFahrzeuge::IM_SHOP_SELECT[$ottosFahrzeuge->im_shop] ?? '' }}
                            </td>
                            <td>
                                {{ $ottosFahrzeuge->pack->packs ?? '' }}
                            </td>
                            <td>
                                @can('ottos_fahrzeuge_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ottos-fahrzeuges.show', $ottosFahrzeuge->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ottos_fahrzeuge_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ottos-fahrzeuges.edit', $ottosFahrzeuge->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ottos_fahrzeuge_delete')
                                    <form action="{{ route('admin.ottos-fahrzeuges.destroy', $ottosFahrzeuge->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('ottos_fahrzeuge_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ottos-fahrzeuges.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-packOttosFahrzeuges:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection