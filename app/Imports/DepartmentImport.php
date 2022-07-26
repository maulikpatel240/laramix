<?php

namespace App\Imports;

use App\Models\Admin\Department;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use App\Imports\ReportImport;

class DepartmentImport implements WithHeadingRow, WithMultipleSheets
{
    use WithConditionalSheets;
    public function conditionalSheets(): array
    {
        return [
            'Report' => new ReportImport(),
            // 'festival' => new ReportImport(),
            // 'relation' => new ReportImport(),
            // 'religion' => new ReportImport(),
        ];
    }
}
