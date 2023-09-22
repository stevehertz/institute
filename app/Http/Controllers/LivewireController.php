<?php


namespace App\Http\Controllers;


use App\Models\Exam;
use Nyholm\Psr7\Request;

class LivewireController extends Controller
{
    private $path;

    public function __construct()
    {
        //
    }
    public function index(Request $request)
    {
        dd($request);
        $exam = Exam::withoutGlobalScope('filter')->where('uniqueExamId', '60f04b1378e73')->with('course')->with('questions')->firstOrFail();

        return view('welcome', compact('exam'));
    }

}