<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PesaPal Payments</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>
<body>

<div class="container">
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Tracting Id</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{$payment->transaction_id}}</td>
                <td>{{$payment->amount}}</td>
                <td>{{$payment->tracking_id}}</td>
                <td>@if($payment->status != 'CONFIRMED')
                        <form action=""></form>
                 @endif
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
<script>
    $(function(){
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    })
</script>
</body>
</html>

