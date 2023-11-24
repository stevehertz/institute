@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', $blog->meta_title ? $blog->meta_title : app_name())
@section('meta_description', $blog->meta_description)
@section('meta_keywords', $blog->meta_keywords)

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-01.jpg') }}');">
        {{-- <h2 class="ltext-105 cl0 txt-center">
            {{ $blog->title }}
        </h2> --}}
    </section>

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ url('/') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{ route('blogs.index') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Blog
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $blog->title }}
            </span>
        </div>
    </div>

    <!-- Content page -->
    <section class="bg0 p-t-52 p-b-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <!--  -->
                        <div class="wrap-pic-w how-pos5-parent">
                            @if ($blog->image != '')
                                <img src="{{ asset('storage/uploads/' . $blog->image) }}" alt="{{ $blog->title }}">
                            @else
                                <img src="{{ asset('storage/images/blog-04.jpg') }}" alt="{{ $blog->title }}">
                            @endif


                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                <span class="ltext-107 cl2 txt-center">
                                    {{ $blog->created_at->format('d') }}
                                </span>

                                <span class="stext-109 cl3 txt-center">
                                    {{ $blog->created_at->format('F Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-t-32">
                            <span class="flex-w flex-m stext-111 cl2 p-b-19">
                                <span>
                                    <span class="cl4">By</span> {{ $blog->author->name }}
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    {{ $blog->created_at->format('d F, Y') }}
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    {{ $blog->category->name }}
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    {{ $blog->comments->count() }} Comments
                                </span>
                            </span>

                            <h4 class="ltext-109 cl2 p-b-28">
                                {{ $blog->title }}
                            </h4>

                            <p class="stext-117 cl6 p-b-26">
                                {!! $blog->content !!}
                            </p>
                        </div>

                        {{-- <div class="flex-w flex-t p-t-16">
                            <span class="size-216 stext-116 cl8 p-t-4">
                                Tags
                            </span>

                            <div class="flex-w size-217">
                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Streetstyle
                                </a>

                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Crafts
                                </a>
                            </div>
                        </div> --}}

                        <!--  -->
                        <div class="p-t-40">
                            <h5 class="mtext-113 cl2 p-b-12">
                                @lang('labels.frontend.blog.post_comments')
                            </h5>

                            {{-- <p class="stext-107 cl6 p-b-40">
                                Your email address will not be published. Required fields are marked *
                            </p> --}}

                            @if (auth()->check())
                                <form method="POST" action="{{route('blogs.comment',['id'=>$blog->id])}}"  data-lead="Residential">
                                    @csrf
                                    <div class="bor19 m-b-20">
                                        <textarea required class="stext-111 cl2 plh3 size-124 p-lr-18 p-tb-15" name="comment" placeholder="Comment..."></textarea>
                                        <span class="help-block text-danger">{{ $errors->first('comment', ':message') }}</span>
                                    </div>

                                    <button type="submit" class="flex-c-m stext-101 cl0 size-125 bg3 bor2 hov-btn3 p-lr-15 trans-04">
                                        @lang('labels.frontend.blog.add_comment')
                                    </button>
                                </form>
                            @else
                            @endif


                        </div>
                    </div>
                </div>

                @include('frontend.blogs.partials.sidebar')
            </div>
        </div>
    </section>

@endsection
