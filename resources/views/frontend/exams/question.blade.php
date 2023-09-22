<h4 class="mb-0">{{ $loop->iteration }}. {!! $question->question !!}  </h4>
<br/>
@foreach ($question->options as $option)
    <div class="radio">
        <label>
            <input type="radio" name="questions[{{ $question->id }}]"
                   value="{{ $option->id }}"/>
            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
            {{ $option->option_text }}<br/>
        </label>
    </div>
@endforeach
<br/>