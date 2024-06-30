<?php

namespace Modules\Core\Imports\Member;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Core\Models\Member;

class MemberImport implements OnEachRow, WithHeadingRow, WithValidation
{
    use Importable;

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        Member::completeInsertViaImport($row);
    }

    public function rules(): array
    {
        $user = auth()->user();

        return [
            'dob' => function ($attribute, $value, $onFailure) {
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value)) {
                    $onFailure('Isian tgl_lahir tidak valid');
                }
            },
        ];
    }
}
