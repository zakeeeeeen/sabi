<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function start()
    {
        Session::forget('quiz.answers');
        Session::forget('quiz.index');

        return redirect()->route('quiz.show');
    }

    public function show()
    {
        $questions = QuizQuestion::query()->orderBy('position')->get();

        if ($questions->isEmpty()) {
            return view('quiz', [
                'question' => null,
                'number' => 0,
                'total' => 0,
                'selected' => null,
            ]);
        }

        $index = (int) Session::get('quiz.index', 0);

        if ($index >= $questions->count()) {
            return redirect()->route('quiz.result');
        }

        $question = $questions[$index];
        $answers = Session::get('quiz.answers', []);
        $selected = $answers[$question->id] ?? null;

        return view('quiz', [
            'question' => $question,
            'number' => $index + 1,
            'total' => $questions->count(),
            'selected' => $selected,
        ]);
    }

    public function answer(Request $request)
    {
        $data = $request->validate([
            'question_id' => ['required', 'integer', 'exists:quiz_questions,id'],
            'answer' => ['required', 'in:a,b,c,d'],
        ]);

        $answers = Session::get('quiz.answers', []);
        $answers[(int) $data['question_id']] = $data['answer'];
        Session::put('quiz.answers', $answers);

        $index = (int) Session::get('quiz.index', 0);
        Session::put('quiz.index', $index + 1);

        return redirect()->route('quiz.show');
    }

    public function result()
    {
        $questions = QuizQuestion::query()->orderBy('position')->get();
        $answers = Session::get('quiz.answers', []);

        $correct = 0;

        foreach ($questions as $question) {
            $selected = $answers[$question->id] ?? null;
            if ($selected && $selected === $question->correct_option) {
                $correct++;
            }
        }

        $total = $questions->count();
        $points = $total > 0 ? (int) round(($correct / $total) * 100) : 0;
        Session::put('quiz.points', $points);

        if (Auth::check()) {
            Auth::user()->update(['quiz_points' => $points]);
        }

        return view('quiz-result', [
            'total' => $total,
            'correct' => $correct,
            'points' => $points,
        ]);
    }
}
