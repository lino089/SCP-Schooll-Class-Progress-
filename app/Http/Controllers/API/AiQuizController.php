<?php

namespace App\Http\Controllers\API;

use App\Models\AiQuiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class AiQuizController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:school_classes,id',
            'topic' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 422);
        }

        // AI generate(dummy)
        $aiGenerateQuestions = [
            [
                "no" => 1,
                "question" => "Berikut ini yang merupakan pemahaman paling tepat tentang " . $request->topic . " adalah...",
                "options" => [
                    "A" => "Jawaban pengecoh pertama",
                    "B" => 'Jawaban paling benar menurut AI',
                    'C' => 'Jawaban pengecoh kedua',
                    'D' => 'Jawaban pengecoh ketiga'
                ],
                'correct_answer' => 'B'
            ],
            [
                "no" => 2,
                "question" => "Berikut ini yang merupakan pemahaman paling tepat tentang " . $request->topic . " adalah...",
                "options" => [
                    "A" => "Jawaban pengecoh pertama",
                    "B" => 'Jawaban paling benar menurut AI',
                    'C' => 'Jawaban pengecoh kedua',
                    'D' => 'Jawaban pengecoh ketiga'
                ],
                'correct_answer' => 'B'
            ]
        ];

        $quiz = AiQuiz::create([
            'teacher_id' => $request->user()->id,
            'class_id' => $request->class_id,
            'topic' => $request->topic,
            'questions_data' => json_encode($aiGenerateQuestions)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis AI berhasil dibuat',
            'data' => $quiz
        ], 201);
    }
}
