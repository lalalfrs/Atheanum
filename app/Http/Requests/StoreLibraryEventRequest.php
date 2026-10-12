<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLibraryEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isLibrarian();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:10000'],
            'location' => ['required', 'string', 'max:160'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'nama acara',
            'description' => 'deskripsi',
            'location' => 'lokasi',
            'starts_at' => 'waktu mulai',
            'ends_at' => 'waktu selesai',
        ];
    }
}
