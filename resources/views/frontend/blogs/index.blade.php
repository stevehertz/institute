@extends('frontend.layouts.app' . config('theme_layout'))
@section('title', trans('labels.frontend.blog.title') . ' | ' . app_name())
@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('storage/images/bg-01.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            @if (isset($category))
                {{ $category->name }}
            @elseif(isset($tag))
                {{ $tag->name }}
            @endif <span>@lang('labels.frontend.blog.title')</span>
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    @if (count($blogs) > 0)
                        <div class="p-r-45 p-r-0-lg">
                            @foreach ($blogs as $item)
                                <!-- item blog -->
                                <div class="p-b-63">
                                    <a href="{{ route('blogs.index', ['slug' => $item->slug . '-' . $item->id]) }}"
                                        class="hov-img0 how-pos5-parent">
                                        @if ($item->image != '')
                                            <img src="{{ asset('storage/uploads/' . $item->image) }}" alt="IMG-BLOG">
                                        @endif
                                        <div class="flex-col-c-m size-123 bg9 how-pos5">
                                            <span class="ltext-107 cl2 txt-center">
                                                {{ $item->created_at->format('d') }}
                                            </span>

                                            <span class="stext-109 cl3 txt-center">
                                                {{ $item->created_at->format('F Y') }}
                                            </span>
                                        </div>
                                    </a>

                                    <div class="p-t-32">
                                        <h4 class="p-b-15">
                                            <a href="{{ route('blogs.index', ['slug' => $item->slug . '-' . $item->id]) }}"
                                                class="ltext-108 cl2 hov-cl1 trans-04">
                                                {{ $item->title }}
                                            </a>
                                        </h4>

                                        <p class="stext-117 cl6">
                                            {!! strip_tags(mb_substr($item->content, 0, 100) . '...') !!}
                                        </p>

                                        <div class="flex-w flex-sb-m p-t-18">
                                            <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                                                <span>
                                                    <span class="cl4">By</span> Admin
                                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                                </span>

                                                <span>
                                                    StreetStyles, Fashion, Couple
                                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                                </span>

                                                <span>
                                                    8 Comments
                                                </span>
                                            </span>

                                            <a href="{{ route('blogs.index', ['slug' => $item->slug . '-' . $item->id]) }}"
                                                class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                                Continue Reading

                                                <i class="fa fa-long-arrow-right m-l-9"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
                                {{ $blogs->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                <!--/.col-md-8 -->

                @include('frontend.includes.desktop.sidebar')
            </div>
        </div>
    </section>
    
@endsection
