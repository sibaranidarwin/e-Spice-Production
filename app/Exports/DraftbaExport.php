<?php

namespace App\Exports;

use App\Draft_BA;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;


class DraftbaExport implements WithEvents,FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    
    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('Patrick');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                
                $event->sheet->protectCells('A1:J1', 'PASSWORD');
                $event->sheet->getStyle('k2:k100')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
    public function collection()
    {
        return Draft_BA::get([
            'gr_date',
            'po_number',
            'mat_desc',
            'vendor_part_number',
            'doc_header_text',
            'po_item',
            'jumlah',
            'jumlah_harga',
            'selisih_harga',
            'status_draft',
        ]);
    }

    public function headings():array{
        return[
            'gr_date',
            'po_number',
            'material_description',
            'vendor_part_number',
            'doc_header_text',
            'item',
            'qty',
            'amount_mkp',
            'total_value',
            'status_ba',
            'reason'
        ];
    } 
}
