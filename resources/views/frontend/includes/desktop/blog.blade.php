<section class="sec-blog bg0 p-t-60 p-b-90">
    <div class="container">
        <div class="p-b-66">
            <h3 class="ltext-105 cl5 txt-center respon1">
                @lang('labels.frontend.layouts.partials.latest_news_blog')
            </h3>
        </div>

        <div class="row">
            @if (count($news) > 0)
                @foreach ($news as $item)
                    <div class="col-sm-6 col-md-4 p-b-40">
                        <div class="blog-item">
                            <div class="hov-img0">
                                @if ($item->image != null)
                                    <a href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}">
                                        <img src="{{ asset('storage/uploads/' . $item->image) }}" alt="IMG-BLOG">
                                    </a>
                                @endif
                            </div>

                            <div class="p-t-15">
                                <div class="stext-107 flex-w p-b-14">
                                    <span>
                                        <span class="cl4">
                                            Created on
                                        </span>

                                        <span class="cl5">
                                            {{ $item->created_at->format('d M Y') }}
                                        </span>
                                    </span>
                                </div>

                                <h4 class="p-b-12">
                                    <a href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}"
                                        class="mtext-101 cl2 hov-cl1 trans-04">
                                        {{ $item->title }}
                                    </a>
                                </h4>

                                <p class="stext-108 cl6">
                                    {!! strip_tags(mb_substr($item->content, 0, 100) . '...') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
