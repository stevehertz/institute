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
        <h4> Exam in progress. Title:  {{$exam->title}} </h4><hr>
    </div>
    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#examInstructions">Instructions: Click to expand/hide <i class="far fa-chevron-square-down"></i></button>
    <div id="examInstructions" class="collapse">
        {!! $exam->exam_instructions !!}
    </div>
    <hr>
    <div>
        @livewire('wizard', ['exam' => $exam])
    </div>
    <hr>

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
