<?php


namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;


class LivewireController extends Controller
{
    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if(session()->has('display_type')){
            if(session('display_type') == 'rtl'){
                $path = 'frontend-rtl';
            }else{
                $path = 'frontend';
            }
        }else if(config('app.display_type') == 'rtl'){
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }
    public function index(Request $request)
    {
        $exam = Exam::withoutGlobalScope('filter')->where('uniqueExamId', $request->uniqueExam)->with('course')->with('questions')->firstOrFail();
        return view('frontend.exams.welcome', compact('exam'));
    }

}