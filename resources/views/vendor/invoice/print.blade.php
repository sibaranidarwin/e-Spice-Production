<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
    body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        color: #333;
        text-align: left;
        font-size: 18px;
        margin: 0;
    }

    .container {
        margin: 0 auto;
        margin-top: 0px;
        /* padding: 40px;
        width: 750px; */
        height: auto;
        background-color: #fff;
    }

    caption {
        font-size: 28px;
        margin-bottom: 15px;
    }

    table {
        border: none;
        border-collapse: collapse;
        /* margin: 0 auto;
        width: 790px; */
    }

    td,
    tr,
    th {
        border: none;
        font-size: 13px;
        width: 109px;
    }

    th {
        background-color: #f0f0f0;
    }

    h4,
    p {
        margin: 0px;
    }
    
    </style>
</head>

<body>
    <div class="container">
        <h4>&nbsp;&nbsp;PT UNITED TRACTORS Tbk</h4>
        <br>
        <p style="font-size: 13px;">&nbsp;&nbsp;Jalan Raya Bekasi Km. 22, Jakarta 13910 - Indonesia<br>
            &nbsp;&nbsp;NPWP : 01.308.524.6-091.000<br><br>
            &nbsp;&nbsp;Kepada (Sold To) : <br>
            &nbsp;&nbsp;PT MANDALA KARYA PRIMA <br>
            &nbsp;&nbsp;PRO MANDIRI BUILDING KOMP SENTRA LATUMENTEN JL.PROF <br>
            &nbsp;&nbsp;DR.LATUMENTEN <br>
            &nbsp;&nbsp;NO.50 RT.009 RW.001 JELAMBAR BARU <br>
            &nbsp;&nbsp;GROGOL PETAMBURAN JAKARTA BARAT 11460 <br>
            &nbsp;&nbsp;NPWP : 02.415.351.2-036.000 <br><br>
        </p>
        @foreach($invoices as $invoice)
        @endforeach
        <table>
            <tr>
                <td colspan="3">Nomor Pelanggan (Account No) : 12278</td>
                <td colspan="1"></td>
                <td></td>
                <td>Nomor Faktur (Invoice Number) : {{$invoice->vendor_invoice_number}}</td>
            </tr>
            <tr>
                <td>Nomor Pesanan (Order Reff) : 4020071510</td>
                <td colspan="3"></td>
                <td></td>
                <td>Tanggal Pesanan (Order Date) : 19 Januari 2022</td>
            </tr>
            <tr>
                <td>Mata uang (Currency) : {{$invoice->currency}}</td>
                <td colspan="3"></td>
                <td></td>
                <td>Sales Order (Sales Order No.) : 0230960070</td>
            </tr>
            <tr>
                <td>Tanggal Faktur (invoice Date) : {{ Carbon\Carbon::parse($invoice->created_at)->format('d F Y') }}</td>
                <td></td>
                <td colspan="3"></td>
                <td>Tanggal Jatuh Tempo (Payment Due Date) : 3 April 2022</td>
            </tr>
            <tr>
                <td>Nomor Faktur Pajak (VAT No.) : {{$invoice->faktur_pajak_number}}</td>
            </tr>
        </table>
        {{-- @endforeach --}}
        <br><br>
        <h4>Data GR Invoice Proposal:</h4>
        <br>
        <table class="table">
            <thead>
                <tr style="text-align: center;">
                    <th>GR Number</th>
                    <th>No PO</th>
                    <th>PO Item</th>
                    <th>GR Slip Date</th>
                    <th>Material Number</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Tax Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr style="text-align: center;">
                    <td>{{$invoice->no_po}}</td>
                    <td>{{$invoice->gr_number}}</td>
                    <td>{{$invoice->po_item}}</td>
                    <td>{{$invoice->gr_date}}</td>
                    <td>{{$invoice->material_number}}</td>
                    <td>{{$invoice->harga_satuan}}</td>
                    <td>{{$invoice->jumlah}}</td>
                    <td>{{$invoice->tax_code}}</td>
                </tr>
                @endforeach
                </select>
            </tbody>
        </table>

    </div>
</body>

</html>