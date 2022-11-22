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
                
                $event->sheet->protectCells('A1:J1', 'PASSWORD');
                $event->sheet->getStyle('K1:L1')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K2:L2')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K3:L3')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K4:L4')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K5:L5')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K6:L6')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K7:L7')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K8:L8')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K9:L9')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K10:L10')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('K11:L11')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                
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
            'keterangan'
        ];
    } 
}
