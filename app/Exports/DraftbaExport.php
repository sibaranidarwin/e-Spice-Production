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
                
                $event->sheet->protectCells('A1:K1', 'PASSWORD');
                $event->sheet->getStyle('L1:N1')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L2:N2')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L3:N3')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L4:N4')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L5:N5')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L6:N6')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L7:N7')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L8:N8')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L9:N9')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L10:N10')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('L11:N11')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                
                $event->sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
    public function collection()
    {
        $user_vendor = Auth::User()->id_vendor;
        return Draft_BA::Where("id_vendor", $user_vendor)->get([
            'gr_date',
            'po_number',
            'mat_desc',
            'vendor_part_number',
            'material_number',
            'valuation_type',
            'doc_header_text',
            'po_item',
            'jumlah',
            'tax_code',
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
            'material_number',
            'valuation_type',
            'doc_header_text',
            'item',
            'qty',
            'tax_code',
            'amount_mkp',
            'total_value',
            'status_ba',
            'keterangan'
        ];
    } 
}
