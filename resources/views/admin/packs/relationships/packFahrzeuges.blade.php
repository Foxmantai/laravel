@can('fahrzeuge_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.fahrzeuges.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fahrzeuge.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.fahrzeuge.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-packFahrzeuges">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.kategorie') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.model') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.fahrzeug') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.preis') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.lieferbar') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.justiert') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.pack') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.imshop') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fahrzeuges as $key => $fahrzeuge)
                        <tr data-entry-id="{{ $fahrzeuge->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $fahrzeuge->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Fahrzeuge::KATEGORIE_SELECT[$fahrzeuge->kategorie] ?? '' }}
                            </td>
                            <td>
                                {{ $fahrzeuge->model ?? '' }}
                            </td>
                            <td>
                                {{ $fahrzeuge->fahrzeug ?? '' }}
                            </td>
                            <td>
                                {{ $fahrzeuge->preis ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Fahrzeuge::LIEFERBAR_SELECT[$fahrzeuge->lieferbar] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Fahrzeuge::JUSTIERT_SELECT[$fahrzeuge->justiert] ?? '' }}
                            </td>
                            <td>
                                {{ $fahrzeuge->pack->packs ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Fahrzeuge::IMSHOP_SELECT[$fahrzeuge->imshop] ?? '' }}
                            </td>
                            <td>
                                @can('fahrzeuge_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.fahrzeuges.show', $fahrzeuge->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('fahrzeuge_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.fahrzeuges.edit', $fahrzeuge->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('fahrzeuge_delete')
                                    <form action="{{ route('admin.fahrzeuges.destroy', $fahrzeuge->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('fahrzeuge_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fahrzeuges.massDestroy') }}",
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
  let table = $('.datatable-packFahrzeuges:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection