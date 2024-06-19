<?php

namespace Modules\Event\Http\Requests\Submission;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:191',
            'content'       => 'required|string',
            'type_id'       => 'nullable|exists:ts_event_types,id',
            'start_at'      => 'required|date_format:Y-m-d|after_or_equal:yesterday',
            'end_at'        => 'required|date_format:Y-m-d|after_or_equal:start_at',
            'price'         => 'nullable|numeric',
            'registrable'   => 'boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'          => 'nama event',
            'content'       => 'deskripsi',
            'type_id'       => 'jenis',
            'start_at'      => 'waktu mulai',
            'end_at'        => 'waktu selesai',
            'price'         => 'biaya registrasi',
            'registrable'   => 'pilihan'
        ];
    }
}