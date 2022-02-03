<?php

namespace App\Exports;

use App\Models\Cart;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CartsExportView implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('carts.table', [
            'carts' => Cart::all()
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
                $num = count(Cart::all()) + 2;
                $event->sheet->getStyle('B2:H2')->applyFromArray([
                    'font' => [
                        'name' => 'ＭＳ ゴシック',
                        'bold' => true,
                        'size' => '12',
                    ],
                    'borders' => [
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);
                $event->sheet->getStyle('B3:H' . $num)->applyFromArray([
                    'font' => [
                        'name' => 'ＭＳ ゴシック',
                        'bold' => false,
                        'size' => '10',
                    ],
                    'borders' => [
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);
            }
        ];
    }
}
