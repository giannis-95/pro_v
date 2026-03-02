<?php

namespace App\Http\Requests\Announcements;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'course_id' => [
                'required',
                Rule::exists('courses','id')->whereNull('deleted_at'),
            ],
            'message' => 'string|nullable',
            'file' => 'file|nullable|max:2048'
        ];
    }
}
