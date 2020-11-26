@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            En Articulos <button id="new" class="btn btn-primary">Crear</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#new').click(function () {
        $.post('{{ route('inv.art.store') }}', {
          _token: $('meta[name="csrf-token"]').attr('content'),
          name: 'Coca Cola 3L',
          barcode: '123456',
          status: 2
        })
        .done(function (r) {
          console.log(r);
        })
        .fail(function (e) {
          console.log(e.responseJSON);
        })
        .always(function () {

        })
      });
    });
  </script>
@endsection
