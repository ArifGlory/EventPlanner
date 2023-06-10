<!DOCTYPE html>
<html lang="en" xmlns:background-color="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Laporan Event <?php echo $user->name; ?> </title>
    <!--<script>
        document.addEventListener('DOMContentLoaded', function(){
            // your code goes here
            window.print();
        }, false);
    </script>-->
    <style type="text/css" media="all">
        hr {
            -moz-border-bottom-colors: none;
            -moz-border-image: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #EEEEEE -moz-use-text-color #FFFFFF;
            border-style: solid none;
            border-width: 1px 0;
            margin: 18px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        'margin: 0 auto;
        }

        .borderless {
            border: 0px;
        }

        .spacer {
            display: block;
            padding-top: 10px;
            padding-bottom: 10px
        }

        .border1 {
            border: 3px solid #000;
            padding: 3px;
        }

        .border1 td {
            border: 1px solid #000;
            padding: 2px;
        }

        .border1 th {
            border: 1px solid #000;
            padding: 3px;
        }

        .tebal2 {
            font-weight: bold;
        }

        #tebal {
            border: 1px solid #000;
            padding: 3px;
            font-weight: normal;
            text-align: center;
        }

        #garis {
            width: 40%;
            border: 1px solid #000000;
        }

        .text-left {
            text-align: left;
        }

        @media print {
            tr.kepala-tabel {
                background-color: #b0bec5 !important;
                -webkit-print-color-adjust: exact;
            }

            html, body {
                width: 210mm;
                height: 330mm;
            }

            header, footer {
                display: none;
            }
        }

        @page {
            /* margin: 0;
             padding-top: 5cm;*/
            margin-top: 2cm;
            margin-bottom: 2cm;
            margin-right: 2cm;
            margin-left: 2cm;
        }

    </style>
    <style type="text/css" media="all">
        .under {
            text-decoration: underline;
            color: #000000;
        }

        .over {
            text-decoration: overline;
        }

        .line {
            text-decoration: line-through;
        }

        .blink {
            text-decoration: blink;
        }

        .all {
            text-decoration: underline overline line-through;
        }

        a {
            text-decoration: none;
        }

        .my-center {
            text-align: center;
        }

        .no-margin-vertical {
            margin-bottom: 0;
            margin-top: 1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h1 style="margin-bottom: 0px;"><?php echo $user->name; ?></h1>
            <h6 style="margin-top: 1px;"><i> Phone <?php echo $user->phone; ?> </i></h6>
        </div>
        <div class="col-md-12">
            <div class="text-center">
                <h2 style="align-self: center;" class="my-center">Laporan Data Transaksi Event <br> </h2>
            </div>
        </div>
        <div class="col-md-9">
            <p class="no-margin-vertical">Laporan dibuat tanggal : <?php echo $now; ?> </p>
            <br>
            <p class="no-margin-vertical">Data Tanggal <?php echo $dari; ?> s/d Tanggal <?php echo $sampai; ?> </p>
        </div>
        <div class="bb-1 mt-1 w-100"></div>
        <div class="bb-3 mt-2 w-100"></div>
        <hr>
    </div>
    <div class="row mt-6">
        <div class="col-md-12">
            <div class="text-center">
                <table class="table border1">
                    <thead class="thead-dark">
                    <tr>
                        <td>No.</td>
                        <td>Event</td>
                        <td>Nama</td>
                        <td>Jumlah</td>
                        <td>Total Bayar</td>
                        <td>Status</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    $total_pendapatan = 0;
                    $total_kekurangan_pendapatan = 0;
                    foreach ($transaksi as $val) {
                        if($val->status == 1){
                            $total_pendapatan += $val->total_bayar;
                        }else if ($val->status == 0){
                            $total_kekurangan_pendapatan += $val->total_bayar;
                        }
                        ?>
                        <tr>
                            <td> <?php echo $no++; ?> </td>
                            <td> <?php echo $val->event_name ?> </td>
                            <td> <?php echo $val->name ?> </td>
                            <td> <?php echo $val->jumlah ?> </td>
                            <td>Rp. <?php echo number_format($val->total_bayar, 0, ',', '.') ?> </td>
                            <td>
                                <?php
                                    if ($val->status == 0){
                                        echo "Menunggu Konfirmasi Pembayaran";
                                    }else if ($val->status == 1){
                                        echo "Pembayaran Diverifikasi";
                                    }else if ($val->status == 1){
                                        echo "Pembayaran Ditolak";
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="row mt-3" style="margin-top: 10px;">
        <div class="col-md-12">
            <p style="margin-top: 1px;">
                Total Transaksi : Rp. <?php echo count($transaksi); ?>
                <br>
                Total Pendapatan : Rp. <?php echo number_format($total_pendapatan,0,',','.')  ?>
                <br>
                Total Pembayaran belum diverifikasi : Rp. <?php echo number_format($total_kekurangan_pendapatan,0,',','.')  ?>
            </p>
        </div>
    </div>
</div>


</body>
</html>
