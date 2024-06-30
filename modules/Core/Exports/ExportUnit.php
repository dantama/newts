<?php

namespace Modules\Core\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Modules\Core\Models\Unit;

class ExportUnit implements FromView, WithEvents, ShouldAutoSize, WithTitle
{
    use Exportable;

    public $units;

    public function __construct()
    {
        $units = Unit::whereType(4)->get();
        $this->units = $units;
    }

    public function title(): string
    {
        return 'Daftar unit';
    }

    public function view(): View
    {
        return view('core::administration.units.excel', ['units' => $this->units]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $cellRange = 'A3:H3';
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                            'color' => ['argb' => 'FFFFFFFF'],
                        ],

                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:H1000')->getAlignment()->setWrapText(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(15);
                $event->sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(15);
                $event->sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(15);
                $event->sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(25);
                $event->sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(35);
            },
        ];
    }
}
