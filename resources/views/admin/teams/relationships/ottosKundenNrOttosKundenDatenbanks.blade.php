@can('ottos_kunden_datenbank_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ottos-kunden-datenbanks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ottosKundenDatenbank.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.ottosKundenDatenbank.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ottosKundenNrOttosKundenDatenbanks">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.ottos_kunden_nr') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.ottos_firma') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.name_nachname') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.strasse_nr') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.plz_ort') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.tel') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.stammkunde') }}
                        </th>
                        <th>
                            {{ trans('cruds.ottosKundenDatenbank.fields.rfe') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ottosKundenDatenbanks as $key => $ottosKundenDatenbank)
                        <tr data-entry-id="{{ $ottosKundenDatenbank->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->ottos_kunden_nr->name ?? '' }}
                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->ottos_firma ?? '' }}
                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->name_nachname ?? '' }}
                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->strasse_nr ?? '' }}
                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->plz_ort ?? '' }}
                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->tel ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\OttosKundenDatenbank::STAMMKUNDE_SELECT[$ottosKundenDatenbank->stammkunde] ?? '' }}
                            </td>
                            <td>
                                {{ $ottosKundenDatenbank->rfe ?? '' }}
                            </td>
                            <td>
                                @can('ottos_kunden_datenbank_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ottos-kunden-datenbanks.show', $ottosKundenDatenbank->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ottos_kunden_datenbank_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ottos-kunden-datenbanks.edit', $ottosKundenDatenbank->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ottos_kunden_datenbank_delete')
                                    <form action="{{ route('admin.ottos-kunden-datenbanks.destroy', $ottosKundenDatenbank->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ottos_kunden_datenbank_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ottos-kunden-datenbanks.massDestroy') }}",
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
    order: [[ 2, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-ottosKundenNrOttosKundenDatenbanks:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection