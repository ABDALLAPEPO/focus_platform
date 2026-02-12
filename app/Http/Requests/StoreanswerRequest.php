<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreanswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'quiz_id' => 'required|exists:quizzes,id',
            // 'student_id' => 'required|exists:student,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id|',
            'answers.*.answer_text' => 'required|string',
        ];
    }
}
