<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DefaultExport implements FromView, WithEvents
{
    use Exportable, RegistersEventListeners;

    protected $info;

    public function __construct(array $info)
    {
        $this->info = $info;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('reports.pdf', $this->info);
    }

    /**
     * @param AfterSheet $event
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function afterSheet(AfterSheet $event)
    {
        $worksheet = $event->sheet->getDelegate();
        $max_rows = $worksheet->getHighestRowAndColumn();
        $worksheet->getStyle("A2:{$max_rows['column']}{$max_rows['row']}")->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN],]]);
        $worksheet->getStyle("A1:{$max_rows['column']}1")->applyFromArray(['font' => ['bold' => true, 'size' => 18], 'alignment' => ['horizontal' => 'center']]);
        $worksheet->getStyle("A2:{$max_rows['column']}2")->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']]);
        $cellIterator = $worksheet->getRowIterator(3)->current()->getCellIterator();
        foreach ($cellIterator as $cell) {
            $worksheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }
    }
}