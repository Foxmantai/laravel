@can('bestellungen_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bestellungens.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bestellungen.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.bestellungen.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-firmaBestellungens">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.firma') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.kunde') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.anzahl') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.fahrzeug') }}
                        </th>
                        <th>
                            {{ trans('cruds.fahrzeuge.fields.preis') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.farbe') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.lieferdatum') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.express') }}
                        </th>
                        <th>
                            {{ trans('cruds.bestellungen.fields.team') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bestellungens as $key => $bestellungen)
                        <tr data-entry-id="{{ $bestellungen->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $bestellungen->firma->firma ?? '' }}
                            </td>
                            <td>
                                @foreach($bestellungen->kundes as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $bestellungen->anzahl ?? '' }}
                            </td>
                            <td>
                                {{ $bestellungen->fahrzeug->fahrzeug ?? '' }}
                            </td>
                            <td>
                                {{ $bestellungen->fahrzeug->preis ?? '' }}
                            </td>
                            <td>
                                {{ $bestellungen->farbe ?? '' }}
                            </td>
                            <td>
                                {{ $bestellungen->lieferdatum ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Bestellungen::STATUS_SELECT[$bestellungen->status] ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $bestellungen->express ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $bestellungen->express ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $bestellungen->team->name ?? '' }}
                            </td>
                            <td>
                                @can('bestellungen_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.bestellungens.show', $bestellungen->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('bestellungen_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.bestellungens.edit', $bestellungen->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('bestellungen_delete')
                                    <form action="{{ route('admin.bestellungens.destroy', $bestellungen->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('bestellungen_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bestellungens.massDestroy') }}",
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
  let table = $('.datatable-firmaBestellungens:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection