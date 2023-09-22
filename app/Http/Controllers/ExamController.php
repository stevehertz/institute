<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Exam;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Cart;

class ExamController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    public function studentExams()
    {
        $exams =0;
        if (\Auth::check()) {
            $exams = Exam::query()->whereHas('student', 'course', '=');
            dd($exams);
        }

        return '00';
    }


    public function all()
    {
        if (request('type') == 'popular') {
            $courses = Exam::withoutGlobalScope('filter')->canDisableExam()->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'trending') {
            $courses = Exam::withoutGlobalScope('filter')->canDisableExam()->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'featured') {
            $courses = Exam::withoutGlobalScope('filter')->canDisableExam()->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else {
            $courses = Exam::withoutGlobalScope('filter')->canDisableExam()->where('published', 1)->orderBy('id', 'desc')->paginate(9);
        }
        $purchased_courses = NULL;
        $purchased_bundles = NULL;
        $categories = Category::where('status', '=', 1)->get();

        if (\Auth::check()) {
            $purchased_courses = Exam::withoutGlobalScope('filter')->canDisableExam()->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('lessons')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_courses = Exam::withoutGlobalScope('filter')->canDisableExam()->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        return view($this->path . '.courses.index', compact('courses', 'purchased_courses', 'recent_news', 'featured_courses', 'categories'));
    }

    public
    function show($course_slug)
    {
        $continue_course = NULL;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $course = Exam::withoutGlobalScope('filter')->where('slug', $course_slug)->with('publishedLessons')->firstOrFail();

        $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
        $anyPendingOrders = \Auth::check() && \DB::table('orders')
                ->where('user_id', \Auth::id())
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('order_items.item_id', $course->id)
                ->first();
        $certified = \Auth::check() && Certificate::where('user_id', \Auth::id())->where('course_id', $course->id)->first();
        $enrolmentStatus = \DB::table('course_student')->where('course_id', $course->id)->where('user_id', \Auth::id())->pluck('status')->first();

        if (($course->published == 0) && ($purchased_course == false)) {
            abort(404);
        }
        $course_rating = 0;
        $total_ratings = 0;
        $completed_lessons = "";
        $is_reviewed = false;
        if (auth()->check() && $course->reviews()->where('user_id', '=', auth()->user()->id)->first()) {
            $is_reviewed = true;
        }
        if ($course->reviews->count() > 0) {
            $course_rating = $course->reviews->avg('rating');
            $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
        }
        $lessons = $course->courseTimeline()->orderby('sequence', 'asc')->get();

        if (\Auth::check()) {

            $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
            $course_lessons = $course->lessons->pluck('id')->toArray();
            $continue_course = $course->courseTimeline()
                ->whereIn('model_id', $course_lessons)
                ->orderby('sequence', 'asc')
                ->whereNotIn('model_id', $completed_lessons)
                ->first();
            if ($continue_course == null) {
                $continue_course = $course->courseTimeline()
                    ->whereIn('model_id', $course_lessons)
                    ->orderby('sequence', 'asc')->first();
            }

        }

        return view($this->path . '.courses.course', compact('course', 'purchased_course', 'recent_news', 'course_rating', 'completed_lessons', 'total_ratings', 'is_reviewed', 'lessons', 'continue_course', 'anyPendingOrders', 'certified', 'enrolmentStatus'));
    }


}
