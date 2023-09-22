<div>
    @if(!empty($successMsg))
        <div class="alert alert-success">
            {{ $successMsg }}
        </div>
    @endif

    @if(empty($examCompleted))

        <div class="row setup-content" id="step-1">
            <div class="col-md-12">
                <h6> {{$qid+1}}. {{ $question1->question}}</h6> <br>
                <div class="content q">
                    @foreach ($question1->options as  $option)
                        <div class="radio q" id="{{rand()}}">
                            <label>
                                <input type="radio" wire:model="questionA.{{$question1->id}}"
                                       value="{{ $option->id }}" />
                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                {{ $option->option_text }}<br/>
                            </label>
                        </div>
                    @endforeach
                    <br>
                    <input wire:model="questionIndex" type="hidden" value="{{$qid}}">
                    <input wire:model="questionIndexId" type="hidden" value="{{$question1->id}}">
                </div>
                <div class="row col-md-12">

                    @if(($qid+1)<$totalQuestions)
                        <div class="col-md-4">
                            <button class="btn btn-primary nextBtn pull-right" wire:click="firstStepSubmit({{$qid}})"
                                    type="button">Next Question
                            </button>
                        </div>
                        <div class="col-md-4">
                            @if($qid ==0)
                                ..
                            @else
                                <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back()">
                                    Previous
                                </button>
                            @endif
                        </div>

                        <div class="col-md-4">
                            {{--                    <button class="btn btn-success btn-lg pull-right" wire:click="submitForm({{$qid}})" type="button"--}}
                            {{--                            id="submitButton1">Finish and submit!--}}
                            {{--                    </button>--}}
                        </div>
                    @else

                        <div class="col-md-4">
                            <button class="btn btn-danger nextBtn pull-right" type="button" wire:click="back()">Previous
                            </button>
                        </div>

                        <div class="col-md-4">

                            <button class="btn btn-success pull-right" wire:click="submitForm({{$qid}})" type="button"
                                    id="submitButton1"><i class="fas fa-check"></i>Finish and submit!
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @else
        <div class="alert alert-success">
            {{ $examCompleted }}
            <a href="{{url('user/dashboard')}}" class="btn btn-success">Go to dashboard</a>
        </div>
    @endif

</div>
<!-- Script -->
{{--<script type='text/javascript'>--}}

{{--    var count = 0;--}}
{{--    var myInterval;--}}
{{--    var timesMoveAway =0;--}}
{{--    // Active--}}
{{--    window.addEventListener('focus', startTimer);--}}
{{--    // Inactive--}}
{{--    window.addEventListener('blur', stopTimer);--}}


{{--    // Start timer--}}
{{--    function startTimer() {--}}
{{--        console.log('focus');--}}
{{--    }--}}

{{--    // Stop timer--}}
{{--    function stopTimer() {--}}
{{--        timesMoveAway++--}}

{{--        if (timesMoveAway>3){--}}
{{--            alert('You have exhausted allowed idle times(3). You are now locked out. \n Please contact the exam supervisor for assistance.');--}}
{{--            document.getElementById("submitButton1").click();--}}
{{--        } else {--}}

{{--            alert("\n Please moving away three(3) times will automatically submit your exam and lock you out.");--}}
{{--        }--}}
{{--    }--}}

{{--</script>--}}
