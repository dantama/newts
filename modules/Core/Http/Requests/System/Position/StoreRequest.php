<?php

namespace Modules\Core\Http\Requests\System\Position;

use App\Http\Requests\FormRequest;
use Modules\Core\Models\Departement;
use Modules\Core\Models\Position;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', Position::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $departments = Departement::all();
        $positions = Position::all();

        return [
            'dept_id'           => 'required|in:' . $departments->pluck('id')->join(','),
            'kd'                => 'required|max:191|string|notin:' . $positions->pluck('kd')->join(','),
            'name'              => 'required|max:191|string',
            'description'       => 'nullable|max:500|string',
            'parents.*'         => 'nullable|in:' . $positions->pluck('id')->join(','),
            'children.*'        => 'nullable|in:' . $positions->pluck('id')->join(','),
            'level'             => 'required|numeric|min:1|max:10',
            'is_visible'        => 'boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'dept_id'           => 'departemen',
            'kd'                => 'kode jabatan',
            'name'              => 'nama jabatan',
            'description'       => 'deskripsi',
            'parents.*'         => 'atasan',
            'children.*'        => 'bawahan',
            'level'             => 'tingkat',
            'is_visible'        => 'visibilitas'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return $this->only([
            'dept_id', 'kd', 'name', 'description', 'parents', 'children', 'level', 'is_visible'
        ]);
    }
}
