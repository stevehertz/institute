@if (auth()->check() &&
        auth()->user()->hasRole('student'))
    <form action="">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course }}">
        <input type="hidden" name="price" value="{{ $price }}">
        <a href="#" type="submit">
            <img class="icon-heart1 dis-block trans-04" src="{{ asset('storage/images/icons/icon-heart-01.png') }}"
                alt="ICON">
        </a>
    </form>
@endif

@if (!auth()->check())
    <div class="block2-txt-child2 flex-r p-t-3">
        <a id="openLoginModal" data-target="#myModal" href="#" class="">
            <img class="icon-heart1 dis-block trans-04" src="{{ asset('storage/images/icons/icon-heart-01.png') }}"
                alt="ICON">
        </a>
    </div>
@endif
