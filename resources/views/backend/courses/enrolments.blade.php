@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.orders.enrolments').' | '.app_name())
@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline mb-0">Enrolments</h3>

        </div>
        <div class="card-body">
            <div class="row"><a href="#">Refresh status</a></div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.course.enrolments') }}"
                           style="{{ request('offline_requests') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                    </li>
                </ul>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>@lang('labels.general.sr_no')</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Start Date</th>
                        <th>Final Score</th>
                        <th>Status</th>
                        <th>&nbsp; @lang('strings.backend.general.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($enrolments as $key => $enrolments)
                        @php $key++ @endphp
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{$enrolments->first_name}} {{$enrolments->last_name}}</td>
                            <td>{{$enrolments->email}}</td>
                            <td>{{$enrolments->title}}</td>
                            <td>{{$enrolments->start_date}}</td>
                            <td>{{$enrolments->final_score}}</td>
                            <td>@if($enrolments->status ==1) <span style="color: green">Active</span> @else <span
                                        style="color: darkred">Deactivated</span> @endif</td>
                            <td>

                                @if($enrolments->status ==1)
                                    <form method="POST" action="{{route('admin.deactivate.enrolment')}}" >
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{$enrolments->course_id}}">
                                        <input type="hidden" name="student_id" value="{{$enrolments->user_id}}">
                                        <input type="hidden" name="status_change" value="0">

                                        <button type="submit">Deactivate </button>
                                    </form>
                                @else

                                <form method="POST" action="{{route('admin.deactivate.enrolment')}}" >
                                @csrf
                                    <input type="hidden" name="course_id" value="{{$enrolments->course_id}}">
                                    <input type="hidden" name="student_id" value="{{$enrolments->user_id}}">
                                    <input type="hidden" name="status_change" value="1">
                                    <button type="submit">Activate </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    {{--    <script>--}}
    {{--        $(document).ready(function () {--}}
    {{--            var route = '{{route('admin.courses.get_enrolment_data')}}';--}}

    {{--            $('#myTable').DataTable({--}}
    {{--                processing: true,--}}
    {{--                serverSide: false,--}}
    {{--                iDisplayLength: 10,--}}
    {{--                retrieve: false,--}}
    {{--                dom: 'lfBrtip<"actions">',--}}
    {{--                buttons: [--}}
    {{--                    {--}}
    {{--                        extend: 'csv',--}}
    {{--                        exportOptions: {--}}
    {{--                            columns: [ 1, 2, 3, 4, 5, 6, 7 ]--}}
    {{--                        }--}}
    {{--                    },--}}
    {{--                    {--}}
    {{--                        extend: 'pdf',--}}
    {{--                        exportOptions: {--}}
    {{--                            columns: [ 1, 2, 3, 4, 5, 6, 7 ]--}}
    {{--                        }--}}
    {{--                    },--}}
    {{--                    'colvis'--}}
    {{--                ],--}}
    {{--                ajax: route,--}}
    {{--                columns: [--}}
    {{--                    {--}}
    {{--                        data: function (data) {--}}
    {{--                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';--}}
    {{--                        }, "orderable": false, "searchable": false, "name": "id"--}}
    {{--                    },--}}
    {{--                    {data: "DT_RowIndex", name: 'DT_RowIndex'},--}}
    {{--                    {data: "first_name", name: 'first_name'},--}}
    {{--                    {data: "actions", name: "actions"}--}}
    {{--                ],--}}
    {{--              createdRow: function (row, data, dataIndex) {--}}
    {{--                    $(row).attr('data-entry-id', data.id);--}}
    {{--                },--}}
    {{--                language:{--}}
    {{--                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",--}}
    {{--                    buttons :{--}}
    {{--                        colvis : '{{trans("datatable.colvis")}}',--}}
    {{--                        pdf : '{{trans("datatable.pdf")}}',--}}
    {{--                        csv : '{{trans("datatable.csv")}}',--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            });--}}

    {{--        });--}}
    {{--    </script>--}}
@endpush