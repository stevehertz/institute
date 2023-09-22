
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .collapsible {
            background-color: #dca6a6;
            color: white;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 12px;
        }

        .active, .collapsible:hover {
            background-color: #c94848;
        }

        .collapsible:after {
            content: '\002B';
            color: white;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .content {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            background-color: #f1f1f1;
        }
    </style>
    <title>Exam in progress</title>
</head>
<body>
<h3>Exam title: {{$exam->title}}</h3>
<button class="collapsible" type="button">Exam instructions</button>
<div class="content">
    <h3>Instructions here</h3>
</div>
<br>
Total allocated time: {{$exam->max_allocated_time}} minutes. Remaining time: <span id="time">{{$exam->max_allocated_time}}</span>
<hr>
<h3>Questions</h3>
<form action="{{ route('admin.exam.submitTest') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden", name="exam_id", value="{{$exam->id}}"/>
    @foreach ($exam->questions as $question)
        <button type="button" class="mb-0 collapsible bg-red box">{{ $loop->iteration }}. {!! $question->question !!}  </button>

        <div class="content q">
            @foreach ($question->options as $option)
                <div class="radio q">
                    <label>
                        <input type="radio" name="questions[{{ $question->id }}]"
                               value="{{ $option->id }}"/>
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        {{ $option->option_text }}<br/>
                    </label>
                </div>
            @endforeach
            <br>
        </div>
    @endforeach
    <br>
    <button class="btn btn-success gradient-bg text-white font-weight-bold" type="submit"
            id="submitButton1"> @lang('labels.frontend.course.submit_exam')  </button>
</form>

<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script>

<!-- Script -->
<script type='text/javascript'>

    var count = 0;
    var myInterval;
    var timesMoveAway =0;
    // Active
    window.addEventListener('focus', startTimer);
    // Inactive
    window.addEventListener('blur', stopTimer);


    // Start timer
    function startTimer() {
        console.log('focus');
    }

    // Stop timer
    function stopTimer() {
        timesMoveAway++

        if (timesMoveAway>10){
            alert('You have exhausted allowed idle times(10). You are now locked out. \n Please contact the exam supervisor for assistance.');
             document.getElementById("submitButton1").click();
        } else {

            alert("You have moved away. \n Please moving away three(10) times will lock you out of the exam room.");
        }
    }

</script>
</body>
</html>




