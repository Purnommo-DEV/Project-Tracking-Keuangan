<?php

namespace App\Exports;

use App\Models\DetailKegiatan;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CatatanHutang implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $t_awal = request()->input('tanggal_awal') ;
        $t_akhir   = request()->input('tanggal_akhir') ;
        return DetailKegiatan::whereBetween('created_at', [ $t_awal, $t_akhir] )->get();
    }

    public function map($catatan) : array {
        return [
            [
                Carbon::parse($catatan->created_at)->format('d F y'),
                $catatan->keterangan,
                $this->rupiahFormat($catatan->piutang),
                $this->rupiahFormat($catatan->terbayar),
                $this->rupiahFormat($catatan->saldo),
            ],

        ];
    }

    public function headings() : array {
        return [
            'Tanggal',
            'Keterangan',
            'Piutang',
            'Terbayar',
            'Saldo',
        ] ;
    }

    public function rupiahFormat($expression)
    {
        return 'Rp.'.number_format($expression,0,',','.');
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function(AfterSheet $event) {

                $sum_piutang = DetailKegiatan::sum('piutang');
                $sum_terbayar = DetailKegiatan::sum('terbayar');
                $total_piutang = DetailKegiatan::sum('saldo');
                $tgl_awal = request()->input('tanggal_awal') ;
                $tgl_akhir   = request()->input('tanggal_akhir');

                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1,3);
                $lastContentColumn = (string) $event->sheet->getDelegate()->getHighestColumn();
                $lastContentRow = (string) $event->sheet->getDelegate()->getHighestRow();
                $lastContentRowTotal = (string) $event->sheet->getDelegate()->getHighestRow();
                $cellE1 = (string) $lastContentColumn . '1';
                $cellELast = (string) 'E' . $lastContentRow;

                $stringTotal = (string) 'B'. $lastContentRowTotal+1;
                $sumPiutang = (string) 'C'. $lastContentRowTotal+1;
                $sumTerbayar = (string) 'D'. $lastContentRowTotal+1;
                $sumSaldo = (string) 'E' . $lastContentRowTotal+1;

                // JUDUL
                $event->sheet->getDelegate()
                    ->setCellValue('A1','LAPORAN.')->mergeCells('A1:E1');

                // PERIODE
                $event->sheet->getDelegate()
                    ->setCellValue('A2','Periode : '.Carbon::parse($tgl_awal)->format('d F y').' - '.Carbon::parse($tgl_akhir)->format('d F y'))->mergeCells('A2:E2');

                // // TOTAL FOOTER
                // $event->sheet->getDelegate()
                //     ->setCellValue($stringTotal, "Total");

                // // SUM PIUTANG FOOTER
                // $event->sheet->getDelegate()
                //     ->setCellValue($sumPiutang, $this->rupiahFormat($sum_piutang));

                // // SUM TERBAYAR FOOTER
                // $event->sheet->getDelegate()
                //     ->setCellValue($sumTerbayar, $this->rupiahFormat($sum_terbayar));

                // // TOTAL PIUTANG FOOTER
                // $event->sheet->getDelegate()
                //     ->setCellValue($sumSaldo, $this->rupiahFormat($total_piutang));


                // JUDUL
                $event->sheet->getDelegate()->getStyle("A1:E1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 15,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                 // PERIODE
                 $event->sheet->getDelegate()->getStyle("A2:E2")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);


                // HEADER
                $event->sheet->getDelegate()->getStyle("A4:E4")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'borders' => [
                        'right'=>[
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // ISI
                $event->sheet->getDelegate()->getStyle("A4:$cellELast")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // FOOTER
                // $event->sheet->getDelegate()->getStyle("$stringTotal:$sumSaldo")->applyFromArray([
                //     'font' => [
                //         'bold' => false,
                //         'size' => 12,
                //     ],
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //             'color' => ['argb' => '000000'],
                //         ],
                //     ],
                //     'alignment' => [
                //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //     ],
                // ]);

            },

        ];
    }

}
