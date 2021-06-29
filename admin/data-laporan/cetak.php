<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan keuangan.xls");
header("Cache-Control: no-cache, must-revalidate");

header("Pragma: no-cache");

require './produk_function.php';
$tgl_awal = $_GET['tgl'];
$myTransaksi = getTransaksiFilter($tgl_awal);

?>
<table id="tabel-data" class="table table-striped table-bordered text-center" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pesan</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 ?>
        <?php $total = 0; ?>
        <?php foreach ($myTransaksi as $myTransaksi) : ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $myTransaksi['tanggal_transaksi'] ?></td>
                <?php
                $sub_total = intval($myTransaksi['product_price']) * intval($myTransaksi['qty']);
                $sub_total2 = number_format($sub_total, 0, ',', '.');
                ?>
                <td>Rp.<?= $sub_total2 ?></td>
            </tr>
            <?php $i++ ?>
            <?php $total += intval($sub_total); ?>
        <?php endforeach; ?>
        <tr>
            <td>Total Pendapatan</td>
            <td></td>
            <td>Rp.<?= number_format($total, 0, ',', '.') ?></td>
        </tr>
    </tbody>
</table>