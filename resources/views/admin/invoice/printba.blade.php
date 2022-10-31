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
        width: 159px;
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
                <td colspan="3"> &nbsp;&nbsp;Nomor Pelanggan (Account No) : 12278</td>
                <td colspan="1"></td>
                <td></td>
                <td> &nbsp;&nbsp;Nomor Faktur (Invoice Number) : 9142</td>
            </tr>
            <tr>
                <td> &nbsp;&nbsp;Nomor Pesanan (Order Reff) : 4020071510</td>
                <td colspan="3"></td>
                <td></td>
                <td> &nbsp;&nbsp;Tanggal Pesanan (Order Date) :
                    {{ Carbon\Carbon::parse($invoice->gr_date)->format('d F Y')}}</td>
            </tr>
            <tr>
                <td> &nbsp;&nbsp;Mata uang (Currency) : {{$invoice->Currency}}</td>
                <td colspan="3"></td>
                <td></td>
                <td> &nbsp;&nbsp;Sales Order (Sales Order No.) : 0230960070</td>
            </tr>
            <tr>
                <td> &nbsp;&nbsp;Tanggal Faktur (invoice Date) :
                    {{ Carbon\Carbon::parse($invoice->created_at)->format('d F Y') }}</td>
                <td></td>
                <td colspan="3"></td>
                <td> &nbsp;&nbsp;Tanggal Jatuh Tempo (Payment Due Date) : 3 April 2023</td>
            </tr>
            <tr>
                <td> &nbsp;&nbsp;Nomor Faktur Pajak (VAT No.) : 010.001-22.66960371</td>
            </tr>
        </table>
        <br><br>
        <h4>&nbsp;&nbsp;Data BA Invoice Proposal:</h4>
        <br>
        <table class="table">
            <thead>
                <tr style="text-align: center;">
                    <th>BA Number</th>
                    <th>PO Number</th>
                    <th>PO MKP</th>
                    <th>GR Date</th>
                    <th>Material</th>
                    <!-- <th class="text-center">Reference</th> -->
                    <!-- <th class="text-center">Vendor Part Number</th>
                            <th class="text-center">Item Description</th>
                            <th class="text-center">UoM</th>
                            <th class="text-center">Currency</th>
                            <th class="text-center">Harga Satuan</th>
                            <th class="text-center">Jumlah</th> -->
                    <!-- <th class="text-center">Jumlah Harga</th> -->
                    {{-- <th>Tax Code</th> --}}
                    <!-- <th class="text-center">Valuation Type</th> -->
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $ba)
                <tr style="text-align: center;">
                    <td><span class="">{{$ba->no_ba}}</span> </td>
                    <td> <span class="">{{$ba->po_number}}</span> </td>
                    <td> <span class="">{{$ba->po_mkp}}</span> </td>
                    <td> <span class="">{{$ba->gr_date}}</span> </td>
                    <td> <span class="">{{$ba->material_bp}}</span></td>
                    <td>{{ $ba->status_ba }}</td>
                </tr>
                @endforeach
                </select>
            </tbody>
        </table>

    </div>
</body>

</html>