<?php

namespace App\Exports;

use App\Draft_BA;
use Auth;
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
            AfterSheet::class    => function(AfterSheet $event) {
                
                $event->sheet->protectCells('A1:Q1', 'PASSWORD');
                $event->sheet->getStyle('R1:R100')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('S1:S100')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('T3:T100')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L4:N4')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L5:N5')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L6:N6')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L7:N7')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L8:N8')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L9:N9')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L10:N10')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('L11:N11')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                
                $event->sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
    public function collection()
    {
        $user_vendor = Auth::User()->id_vendor;
        return Draft_BA::Where("id_vendor", $user_vendor)->get([
            'no_draft',
            'gr_date',
            'po_number',
            'po_item',
            'mat_desc',
            'vendor_part_number',
            'material_number',
            'ref_doc_no',
            'valuation_type',
            'doc_header_text',
            'jumlah',
            'uom',  
            'currency',
            'delivery_note',
            'tax_code',
            'harga_satuan',
            'jumlah_harga',
            'status_draft',
        ]);
    }

    public function headings():array{
        return[
            'no_draft_ba',
            'gr_date',
            'po_number',
            'item',
            'material_description',
            'vendor_part_number',
            'material_number',
            'ref_doc_no',
            'valuation_type',
            'doc_header_text',
            'qty',
            'uom',
            'currency',
            'delivery_note',
            'tax_code',
            'harga_satuan',
            'jumlah_harga',
            'status_ba',
            'ba_number_vendor',
            'keterangan'
        ];
    } 
}
