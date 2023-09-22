<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam in progress</title>
    @livewireStyles

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap">
    <link href="{{ asset('multiform.css') }}" rel="stylesheet" id="bootstrap">
</head>

<body class="mt-5">
<div class="container">
    <div class="text-left">
        Exam in progress
    </div>
    <div class="text-left">
       Exam title:  {{$exam->title}}
    </div>
    <div>
        @livewire('wizard', ['exam' => $exam])
    </div>

</div>
</body>

<script type="text/javascript">
    function incrementValue()
    {
        var value = parseInt(document.getElementById('buttonNext').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('buttonNext').value = value;
    }
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
@livewireScripts


</html>
