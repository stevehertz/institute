@extends('frontend.layouts.app'. config('theme_layout'))

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@section('content')
    <!-- Slider -->
    @include('frontend.includes.desktop.slider')

    <!-- Banner -->
    @include('frontend.includes.desktop.banner')

    <!-- Courses -->
    @include('frontend.includes.desktop.popular-courses')

    <!-- Blog -->
    @include('frontend.includes.desktop.blog')
@endsection
