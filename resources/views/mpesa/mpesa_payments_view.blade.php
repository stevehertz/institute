@extends('header')

@section('head')
    @parent

    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" type="text/css"/>
<title>Mpesa Payments</title>
@stop

@section('content')

    <div class="container-fluid">
                <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered">
                                    <thead class="">
                                    <tr>
                                        <th>S/L</th>
                                        <th>Trans Code</th>
                                        <th>Amount</th>
                                        <th>Invoice Number</th>
                                        <th>Phone Phone</th>
                                        <th>Name</th>
                                        <th>Date and Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! $sl=null !!}
                                    @foreach($payments AS $value)
                                        <tr class="{!! $value->user_id !!}">
                                            <td style="">{!! ++$sl !!}</td>
                                            <td>@if(isset($value->TransID)){!!  $value->TransID  !!}@endif</td>

                                            <td>{!! $value->TransAmount !!}</td>
                                            <td>@if(isset($value->BillRefNumber)){!!  $value->BillRefNumber  !!}@endif</td>
                                            <td>{!! $value->CustomerPhone !!}</td>
                                            <td>{!! $value->FirstName !!} {!! $value->LastName !!}</td>
                                            <td>{!! $value->TransTime !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_scripts')
    <script>
        $(function () {
            $(".select2").select2();
            $('#myTable').DataTable({
                "ordering": false,
            });

        });
        $(function() {
            $('.data').on('click', '.pagination a', function (e) {
                getData($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });


        });

    </script>

@endsection

