<?php

namespace App\Http\Controllers\API;

use App\Models\AiQuiz;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class QuizSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required|exists:ai_quizzes,id',
            'answers' => 'required|array',
            'answers.*.no' => 'required|integer',
            'answers.*.answer' => 'required|in:A,B,C,D'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $quiz = AiQuiz::find($request->quiz_id);

        $questions = json_decode($quiz->questions_data, true);

        $correctCount = 0;
        $totalQuestions = count($questions);
        $studentAnswerLog = [];

        foreach ($request->answers as $studentAns) {
            $no = $studentAns['no'];
            $answer = $studentAns['answer'];
            $isCorrect = false;

            foreach ($questions as $q) {
                if ($q['no'] == $no) {
                    if ($q['correct_answer'] === $answer) {
                        $correctCount++;
                        $isCorrect = true;
                    }
                    break;
                }
                
            }
            $studentAnswerLog[] = [
                'no' => $no,
                'answer' => $answer,
                'is_correct' => $isCorrect
            ];
        }

        $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;

        $submission = QuizSubmission::create([
            'quiz_id' => $quiz->id,
            'student_id' => $request->user()->id,
            'score' => round($score),
            'student_answers_data' => json_encode($studentAnswerLog)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil dikumpulkan.',
            'score' => round($score),
            'data' => $submission
        ], 201);
    }
}
