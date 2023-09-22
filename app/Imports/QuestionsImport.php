<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionsOption;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class QuestionsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach ($rows->chunk(5) as $row)
        {

            $row2 = $row->collapse();
            $examId= Exam::where('uniqueExamId', $row2[3])->pluck('id')->first();


            $data = [
                'question' =>$row2[1],
                'exam'=>$examId,
                'qo1'=>$row2[5],
                'qo1_correct'=>$row2[6],
                'qo2'=>$row2[9],
                'qo2_correct'=>$row2[10],
                'qo3'=>$row2[13],
                'qo3_correct'=>$row2[14],
                'qo4'=>$row2[17],
                'qo4_correct'=>$row2[18],
            ];

            $raw1 =$row->toArray();
            $examQuestion = ExamQuestion::create([
                'question' => $data['question'],
                'score' => 1,
                'user_id' => auth()->user()->id,
            ]);
            $examQuestion->save();
            $examQuestion->exams()->sync($data['exam']);

            $questionOption1 = ExamQuestionsOption::create([
                'question_id' =>$examQuestion->id,
                'option_text' =>$data['qo1'],
                'correct' =>$data['qo1_correct'],
            ]);
            $questionOption2 = ExamQuestionsOption::create([
                'question_id' =>$examQuestion->id,
                'option_text' =>$data['qo2'],
                'correct' =>$data['qo2_correct'],
            ]);
            $questionOption3 = ExamQuestionsOption::create([
                'question_id' =>$examQuestion->id,
                'option_text' =>$data['qo3'],
                'correct' =>$data['qo3_correct'],
            ]);
            $questionOption4 = ExamQuestionsOption::create([
                'question_id' =>$examQuestion->id,
                'option_text' =>$data['qo4'],
                'correct' =>$data['qo4_correct'],
            ]);
        }

    }
}
