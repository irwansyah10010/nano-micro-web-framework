<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$mahasiswa = new model\Mahasiswa();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            inc("home/include/navigasi");
        ?>
        <h2>Data Mahasiswa</h2>
        <a href="<?php url('Mahasiswa/add/') ?>">Tambah Data</a>
        <table border="1">
            <thead>
                <tr>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Proses</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $mahasiswa->select($mahasiswa->getTable())->ready();
            
                while($row = $mahasiswa->getStatement()->fetch()){ ?>
                    <tr>
                        <td><?php echo $row[0]?></td>
                        <td><?php echo $row[1]?></td>
                        <td><?php echo $row[2]?></td>
                        <td><?php echo $row[3]?></td>
                        <td><?php echo $row[4]?></td>
                        <td><a href="<?php url("Mahasiswa/perbarui/".$row[0]."/")?>">perbarui</a> 
                            <a href="<?php url("hapusMahasiswa/".$row[0]."/")?>">hapus</a></td>
                    </tr>
            <?php   }
            ?>
            </tbody>
        </table>
    </body>
</html>
