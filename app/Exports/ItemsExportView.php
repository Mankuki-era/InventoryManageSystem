<?php

namespace App\Exports;

use App\Models\Item;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ItemsExportView implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\FromView
    */
    public function view(): View
    {
        return view('items.table', [
            'items' => Item::all()
        ]);
    }

    public function ShouldAutoSize()
    {
        return true;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $num = count(Item::all()) + 1;
                $event->sheet->getStyle('A1:P1')->applyFromArray([
                    'font' => [
                        'name' => 'ＭＳ ゴシック',
                        'bold' => false,
                        'size' => '11',
                    ],
                    'borders' => [
                        'vertical' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '00000000'],
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);
                $event->sheet->getStyle('A2:P' . $num)->applyFromArray([
                    'font' => [
                        'name' => 'ＭＳ ゴシック',
                        'bold' => false,
                        'size' => '11',
                    ],
                    'borders' => [
                        'vertical' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '00000000'],
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);
            }
        ];
    }
}
