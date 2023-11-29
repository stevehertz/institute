@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', $page->meta_title ? $page->meta_title : app_name())
@section('meta_description', $page->meta_description ? $page->meta_description : '')
@section('meta_keywords', $page->meta_keywords ? $page->meta_keywords : app_name())

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-04.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            {{-- <span>{{ $page->title }}</span> --}}
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container-fluid">
            <div class="container">
                <div class="row p-b-148">
                    @if ($page->image != null)
                        <div class="col-md-7 col-lg-8">
                            <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md apply-content">
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

                            <div class="apply-registration">
                                <div class="bor10">
                                    <a href="javascript:void(0)" id="openLoginModal" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                        Register today to apply
                                    </a>
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
            </div>
            <!--/.container -->
        </div>
        <!--/.container-fluid -->
        
    </section>

@endsection
