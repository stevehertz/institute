<div class="col-md-4 col-lg-3 p-b-80">
    <div class="side-menu">
        <div class="bor17 of-hidden pos-relative">
            <form action="{{ route('blogs.search') }}" method="get">
                <input name="q" class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text"
                    placeholder="@lang('labels.frontend.blog.search_blog')">
                <button type="submit" class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
            </form>
        </div>

        <div class="p-t-55">
            @if ($categories != '')
                <h4 class="mtext-112 cl2 p-b-33">
                    @lang('labels.frontend.blog.blog_categories')
                </h4>

                <ul>
                    @if (count($categories) > 0)
                        @foreach ($categories as $item)
                            <li class="bor18">
                                <a href="{{ route('blogs.category', ['category' => $item->slug]) }}"
                                    class="@if (isset($category) && $item->slug == $category->slug) active @endif dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                    {{ $item->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            @endif
        </div>

        <div class="p-t-65">
            @if ($global_featured_course != '')
                <h4 class="mtext-112 cl2 p-b-33">
                    @lang('labels.frontend.blog.featured_course')
                </h4>
                <ul>
                    <li class="flex-w flex-t p-b-30">
                        <a href="#" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                            <img src="{{ asset('storage/uploads/' . $global_featured_course->course_image) }}"
                                alt="PRODUCT" style="width: 100%;">
                        </a>

                        <div class="size-215 flex-col-t p-t-8">
                            <a href="{{ route('courses.show', [$global_featured_course->slug]) }}"
                                class="stext-116 cl8 hov-cl1 trans-04">
                                {{ $global_featured_course->title }}
                            </a>

                            <span class="stext-116 cl6 p-t-20">
                                {{ $global_featured_course->category->name }}
                            </span>
                        </div>
                    </li>
                </ul>
            @endif
        </div>

        <div class="p-t-50">
            @if (count($popular_tags) > 0)
                <h4 class="mtext-112 cl2 p-b-27">
                    @lang('labels.frontend.blog.popular_tags')
                </h4>

                <div class="flex-w m-r--5">
                    @foreach ($popular_tags as $item)
                        <a href="{{route('blogs.tag',['tag'=>$item->slug])}}"
                            class=" @if (isset($tag) && $item->slug == $tag->slug) active @endif flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                            {{ $item->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
