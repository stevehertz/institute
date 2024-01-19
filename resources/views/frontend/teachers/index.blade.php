@extends('frontend.layouts.app' . config('theme_layout'))

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-04.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            @lang('labels.frontend.teacher.title')
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120 teacher-page-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="teachers-archive">
                        <div class="row">
                            @if (count($teachers) > 0)
                                @foreach ($teachers as $item)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="teacher-pic-content">
                                            <div class="teacher-img-content relative-position">
                                                <img src="{{ $item->picture }}" alt="{{ $item->full_name }}">
                                                <div class="teacher-hover-item">
                                                    <div class="teacher-social-name ul-li-block">
                                                        <ul>
                                                            <li>
                                                                <a href="#">
                                                                    <i class="fa fa-envelope"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('admin.messages',['teacher_id'=>$item->id])}}">
                                                                    <i class="fa fa-comments"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="teacher-name-designation">
                                                <span class="teacher-name">{{$item->full_name}}</span>
                                                {{--<span class="teacher-designation">Mobile Apps</span>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <h4>@lang('lables.general.no_data_available')</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--/.teachers-archive -->
                </div>
            </div>
        </div>
        <!--/.container -->
    </section>
    <!--/.bg0 p-t-75 p-b-120 -->

@endsection
