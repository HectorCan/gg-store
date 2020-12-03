@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net/css/jquery.dataTables.min.css') }}" />

    <style>
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary" id="new">New</button>
                        </div>
                    </div>

                    <table id="tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="fm-create" class="fmi fmc">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="" class="control-label"><span class="text-danger">*</span> Name</label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="" placeholder="Name" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="control-label"><span class="text-danger">*</span> Price</label>
                                    <input type="text" name="price" class="form-control form-control-sm" value="" placeholder="Price" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="control-label"><span class="text-danger">*</span> Stock</label>
                                    <input type="number" min="0"  name="stock" class="form-control form-control-sm" value="0" placeholder="Stock" required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <span><i class="text-danger">*</i> is required</span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

                <form id="fm-edit" class="fmi fme">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id" value="">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="" class="control-label"><span class="text-danger">*</span> Name</label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="" placeholder="Name" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="control-label"><span class="text-danger">*</span> Price</label>
                                    <input type="text" name="price" class="form-control form-control-sm" value="" placeholder="Price" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="control-label"><span class="text-danger">*</span> Stock</label>
                                    <input type="number" min="0"  name="stock" class="form-control form-control-sm" value="0" placeholder="Stock" required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <span><i class="text-danger">*</i> is required</span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            var tbldt = $('#tbl').DataTable({
                serverSide: true, destroy: true, orderCellsTop: false, sType:'string', autoWidth: false, scrollY: 450, scrollX: true,
                order: [[0 , 'asc']],
                ajax: {
                    url: '{{ route('product.dt') }}',
                    dataType: 'json',
                    type: 'POST',
                    data: function (d) {
                        return $.extend({}, d, {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        });
                    }
                },
                dom: "<'#dt_header'>  <'#dt_body 'tr>  <'#dt_footer' <'text-center'i <'pull-right'p>>>",
                columns: [
                    { name: 'id', data: 'id', width: '50px', defaultContent: '-', orderable: false },
                    { name: 'name', data: 'name', width: '200px', defaultContent: '-', orderable: false },
                    { name: 'stock', data: 'stock', width: '200px', defaultContent: '-', orderable: false, render: function (d) { return d + ' Items'; } },
                    { name: 'price', data: 'price', width: '200px', defaultContent: '-', orderable: false, render: function (d) { return '$ ' + d;} },
                    { name: 'created_at', data: 'created_at', width: '200px', defaultContent: '-', orderable: false },
                    { name: 'updated_at', data: 'updated_at', width: '200px', defaultContent: '-', orderable: false },
                    { name: 'actions', data: 'actions', width: '300px', defaultContent: '-', orderable: false, render: function (d, t, r) {
                            return '<button class="selrow btn btn-sm btn-info btn-edit">Edit</button> ' +
                                '<button class="selrow btn btn-sm btn-danger btn-del">Delete</button>';
                        }}
                ],
                drawCallback: function (settings) {
                    var tbl = $(this);

                    tbl.find('.selrow').click( function() {
                        tbldt.selrow = $(this).closest('tr');
                    });

                    tbl.find('.btn-edit').click(function () {
                        var d = tbldt.row(tbldt.selrow).data();
                        var c = $('#modal').find('#fm-edit');
                        display_form('e');
                        c.find('[name="id"]').val(d.id);
                        c.find('[name="name"]').val(d.name);
                        c.find('[name="stock"]').val(d.stock);
                        c.find('[name="price"]').val(d.price);

                        $('#modal').modal('show');
                    });

                    tbl.find('.btn-del').click(function () {
                        if (confirm('are you sure?')) {
                            $.ajax('{{ route('product.delete') }}', {
                                type: 'DELETE',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    id: tbldt.row(tbldt.selrow).data().id
                                },
                                success: function (r) {
                                    if (r.m) {
                                        alert(r.m);
                                        tbldt.draw();
                                    }
                                },
                                error: function (e) {
                                    if (e.responseJSON && e.responseJSON.m) {
                                        alert(e.responseJSON.m)
                                    }
                                },
                                always: function () {

                                }
                            });
                        }
                    });
                },
                initComplete: function () {
                }
            })

            function display_form(i) {
                var c = $('#modal');
                c.find('.fmi').hide();

                c.find('.fm'+i).show();
            }

            $('#modal').find('form').on('reset', function () {
                $(this).find('[name="id"]').val('');
            });

            $('#new').click(function () {
                display_form('c');
                $('#modal').find('#fm-create')[0].reset();

                $('#modal').modal('show');
            });

            $('#modal').find('#fm-create').ajaxForm({
                url: '{{ route('product.store') }}',
                type: 'POST',
                success:  function (r) {
                    if (r.m) {
                        tbldt.draw();
                        $('#modal').modal('hide');
                    }
                },
                error: function (e) {
                    if (e.responseJSON) {
                        if (e.responseJSON.m) {
                            alert(e.responseJSON.m);
                        } else {
                            console.log(e.responseJSON);
                        }
                    }
                },
                always: function () {

                }
            });

            $('#modal').find('#fm-edit').ajaxForm({
                url: '{{ route('product.update') }}',
                type: 'PUT',
                success:  function (r) {
                    if (r.m) {
                        tbldt.draw();
                        $('#modal').modal('hide');
                    }
                },
                error: function (e) {
                    if (e.responseJSON) {
                        if (e.responseJSON.m) {
                            alert(e.responseJSON.m);
                        } else {
                            console.log(e.responseJSON);
                        }
                    }
                },
                always: function () {

                }
            });
        });
    </script>
@endsection
