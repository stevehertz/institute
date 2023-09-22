@extends('backend.layouts.app')
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }


    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.exams.title')</h3>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>Registration Date</th>
                                <th>Title</th>
                                <th>Exam Date</th>
                                <th>Pass Mark</th>

                                @if( request('show_deleted') == 1 )
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @else
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exams as $key=>$exam)
                                @php $key++ @endphp
                                <tr>
                                    <td>
                                        {{ $key }}
                                    </td>
                                    <td>
                                        {{$exam->students[0]->pivot->created_at->format('d M, Y | h:i A')}}
                                    </td>
                                    <td>
                                        {{$exam->title}}
                                    </td>
                                    <td>
                                        {{$exam->scheduled_start_time}}
                                    </td>
                                    <td>
                                        {{$exam->pass_mark}}
                                    </td>


                                    <td>
                                        @php
                                            $hashids = new \Hashids\Hashids('',5);
                                                 $order_id = $hashids->encode($exam->max_allocated_time);
                                                @endphp

                                        @if(sizeof($exam->examResults))
                                            <form action="{{route('admin.exam.viewResults')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uniqueExam" value="{{$exam->uniqueExamId}}">
                                                <input type="submit" value="View Results" class="btn mb-1 btn-danger">
                                            </form>

                                        @else
                                            <form action="{{route('admin.exam.previewExam')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uniqueExam" value="{{$exam->uniqueExamId}}">
                                                <input type="submit" value="Preview" class="btn mb-1 btn-danger">
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
        </div>
    </div>


@endsection

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>

    <script>


        $(document).ready(function () {

            $('#myTable').DataTable({
                processing: true,
                serverSide: false,
                iDisplayLength: 10,
                retrieve: true,


                columnDefs: [
                    {"width": "10%", "targets": 0},
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }

            });
        });

        $('ul.sorter').amigoSorter({
            li_helper: "li_helper",
            li_empty: "empty",
        });
    </script>
@endpush

