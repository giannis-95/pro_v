<?php

namespace App\Http\Requests\Announcements;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAnnouncementRequest extends FormRequest
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
            'title' => 'string|max:255|required',
            'course_id' => [
                'required',
                Rule::exists('courses','id')->whereNull('deleted_at')
            ],
            'message' => 'string|nullable',
            'file' => 'nullable|file|max:2048',
        ];
    }
}
