<?php

namespace Modules\Core\Http\Requests\Approval;

use App\Enums\ApprovableResultEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Http\Requests\FormRequest;
use Modules\Evaluation\Models\EvaluationReport;

class UpdateRequest extends FormRequest
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
            'approve' => ['required', new Enum(ApprovableResultEnum::class)],
            'reason'  => Rule::requiredIf(ApprovableResultEnum::tryFrom($this->input('approve'))->reasonRequirement())
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'approve' => 'status',
            'reason'  => 'alasan'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'result' => $this->input('approve'),
            'reason' => $this->input('reason')
        ];
    }
}
