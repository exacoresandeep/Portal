<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssignedAssetExport implements FromCollection, WithHeadings
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets->map(function ($asset) {

            return [
                'Employee ID'      => $asset->employee->emp_id ?? '',
                'Employee Name'    => $asset->employee->name ?? '',
                'Laptop Brand'     => $asset->laptop_brand,
                'Asset Number'     => $asset->asset_no,
                'Vendor'           => $asset->vendor,
                'Mouse Code'       => $asset->mouse_code,
                'Serial Number'    => $asset->serial_no,
                'RAM'              => $asset->ram,
                'System Config'    => $asset->sys_config,
                'OS Version'       => $asset->os_version,
                'Status'           => $asset->status,
                'Allocated At'     => optional($asset->created_at)->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Employee Name',
            'Laptop Brand',
            'Asset Number',
            'Vendor',
            'Mouse Code',
            'Serial Number',
            'RAM',
            'System Config',
            'OS Version',
            'Status',
            'Allocated At'
        ];
    }
}