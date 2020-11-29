@extends('layouts.app')

@push('before')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js" defer></script>
    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js" defer></script>

    <link rel="stylesheet" href="{{ asset('icon/font/css/open-iconic-bootstrap.css') }}">
@endpush

@push('after')
    <script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('role.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        setTimeout(function(){
            $('.delete-role').click(function(e) {
                e.preventDefault()
                if (confirm('Are you sure?')) {
                    $(e.target).closest('form').submit();
                }
            });
        }, 2000);

    });
    </script>
@endpush

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
    @endif
      
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="float-left">Roles</div>
            <div class="float-right">
                @can('create role')
                    <a href="{{ route('role.create') }}" class="edit btn btn-primary btn-sm">Create</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table class="display table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="30px">No</th>
                        <th>Name</th>
                        <th width="84px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection