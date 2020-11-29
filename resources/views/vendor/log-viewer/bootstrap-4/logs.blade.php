@extends('layouts.app')

@push('before')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('css/logviewer.css') }}" rel="stylesheet">
@endpush

@push('after')
    {{-- DELETE MODAL --}}
    <div id="delete-log-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Delete log file')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary mr-auto" data-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="@lang('Loading')&hellip;">@lang('Delete')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            $("a[href='#delete-log-modal']").on('click', function(event) {
                event.preventDefault();
                var date    = $(this).data('log-date'),
                    message = "{{ __('Are you sure you want to delete this log file: :date ?') }}";

                deleteLogForm.find('input[name=date]').val(date);
                deleteLogModal.find('.modal-body p').html(message.replace(':date', date));

                deleteLogModal.modal('show');
            });

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('AJAX ERROR ! Check the console !');
                            console.error(data);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });

            deleteLogModal.on('hidden.bs.modal', function() {
                deleteLogForm.find('input[name=date]').val('');
                deleteLogModal.find('.modal-body p').html('');
            });
        });
    </script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-left">Audit > Log Viewer > Logs</div>
            <div class="float-right"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <a href="{{ route('log-viewer::dashboard') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            @foreach($headers as $key => $header)
                            <th scope="col" class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                @if ($key == 'date')
                                    <span class="badge badge-info">{{ $header }}</span>
                                @else
                                    <span class="badge badge-level-{{ $key }}">
                                        {{ log_styler()->icon($key) }} {{ $header }}
                                    </span>
                                @endif
                            </th>
                            @endforeach
                            <th scope="col" class="text-right">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $date => $row)
                            <tr>
                                @foreach($row as $key => $value)
                                    <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                        @if ($key == 'date')
                                            <span class="badge badge-primary">{{ $value }}</span>
                                        @elseif ($value == 0)
                                            <span class="badge empty">{{ $value }}</span>
                                        @else
                                            <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                                <span class="badge badge-level-{{ $key }}">{{ $value }}</span>
                                            </a>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-right">
                                    @can('view logviewer')
                                        <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endcan
                                    @can('delete logviewer')
                                        <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-log-date="{{ $date }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    <span class="badge badge-secondary">@lang('The list of logs is empty!')</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $rows->render() }}
        </div>
    </div>
@endsection