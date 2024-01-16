@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', $page->meta_title ? $page->meta_title : app_name())
@section('meta_description', $page->meta_description ? $page->meta_description : '')
@section('meta_keywords', $page->meta_keywords ? $page->meta_keywords : app_name())

@push('after-styles')
    <style>
        .content img {
            margin: 10px;
        }

        .about-page-section ul {
            padding-left: 20px;
            font-size: 20px;
            color: #333333;
            font-weight: 300;
            margin-bottom: 25px;
        }
    </style>
@endpush

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-04.jpg') }}');">
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container">
            <div class="row p-b-148">
                @if ($page->image != null)
                    <div class="col-md-7 col-lg-8">
                        <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md about-content">
                            <h3 class="mtext-111 cl2 p-b-16 txt-center">
                                {{ $page->title }}
                            </h3>

                            {!! $page->content !!}

                        </div>
                    </div>

                    <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                        <div class="">
                            <div class="hov-img0">
                                <img src="{{ asset('storage/uploads/' . $page->image) }}" alt="{{ $page->title }}">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 col-lg-12">
                        <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                            <h3 class="mtext-111 text-center cl2 p-b-16">
                                {{ $page->title }}
                            </h3>

                            {!! $page->content !!}
                        </div>
                    </div>
                @endif

            </div>
            <!--/.row -->

            @if ($page->slug == 'our-partners')
                @if (count($partners) > 0)
                    <div class="row">
                        @foreach ($partners as $partner)
                            <div class="col-md-2 partners-img">
                                <img src="{{ asset('storage/uploads/' . $partner->logo) }}" alt="" class="img-circle">
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
        <!--/.container -->
    </section>


@endsection
