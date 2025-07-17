@can('kunden_datenbank_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.kunden-datenbanks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.kundenDatenbank.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.kundenDatenbank.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-kundennrKundenDatenbanks">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.kundenDatenbank.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.kundenDatenbank.fields.adresse') }}
                        </th>
                        <th>
                            {{ trans('cruds.kundenDatenbank.fields.plz_ort') }}
                        </th>
                        <th>
                            {{ trans('cruds.kundenDatenbank.fields.tel') }}
                        </th>
                        <th>
                            {{ trans('cruds.kundenDatenbank.fields.kundennr') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kundenDatenbanks as $key => $kundenDatenbank)
                        <tr data-entry-id="{{ $kundenDatenbank->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $kundenDatenbank->name ?? '' }}
                            </td>
                            <td>
                                {{ $kundenDatenbank->adresse ?? '' }}
                            </td>
                            <td>
                                {{ $kundenDatenbank->plz_ort ?? '' }}
                            </td>
                            <td>
                                {{ $kundenDatenbank->tel ?? '' }}
                            </td>
                            <td>
                                {{ $kundenDatenbank->kundennr->kunden_nr ?? '' }}
                            </td>
                            <td>
                                @can('kunden_datenbank_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.kunden-datenbanks.show', $kundenDatenbank->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('kunden_datenbank_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.kunden-datenbanks.edit', $kundenDatenbank->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('kunden_datenbank_delete')
                                    <form action="{{ route('admin.kunden-datenbanks.destroy', $kundenDatenbank->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('kunden_datenbank_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.kunden-datenbanks.massDestroy') }}",
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
  let table = $('.datatable-kundennrKundenDatenbanks:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection