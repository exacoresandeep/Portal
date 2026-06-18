<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetRequestExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($row) {

            return [
                'Department'      => $row->department->name ?? '',
                'Joining Date'    => \Carbon\Carbon::parse($row->joining_date)->format('d-m-Y'),
                'Laptop Count'    => $row->laptop_count,
                'Request Status'  => $row->request_status,
                'Status'          => ucfirst($row->status),
                'Requested Date'  => $row->created_at->format('d-m-Y'),
            ];

        });
    }

    public function headings(): array
    {
        return [
            'Department',
            'Joining Date',
            'Laptop Count',
            'Request Status',
            'Status',
            'Requested Date'
        ];
    }
}
