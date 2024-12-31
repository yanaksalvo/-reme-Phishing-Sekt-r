<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veri Listesi</title>
    <style>
        body {
            background-color: #121212;
            color: #d0d0d0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1e1e2f;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #2a2a3c;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #2a2a3c;
            color: #00bcd4;
        }
        .header {
            text-align: center;
            padding: 20px;
        }
        .actions {
            margin: 10px 0;
            text-align: center;
        }
        .actions button {
            padding: 10px 20px;
            background-color: #00bcd4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions button:hover {
            background-color: #008c9e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LOG Json Veri Listesi</h1>
        </div>
        <div class="actions">
            <form action="" method="post">
                <button type="submit" name="download">Excel Olarak İndir</button>
                <button type="submit" name="delete">Tümünü Sil</button>
            </form>
        </div>
        <?php
        $filePath = 'data.json';

        if (file_exists($filePath)) {
            $jsonVeri = file_get_contents($filePath);
            $veriler = json_decode($jsonVeri, true);

            if (!empty($veriler)) {
                // Tarihe göre sıralama (yeniden eskiye)
                usort($veriler, function ($a, $b) {
                    return strtotime($b['tarih']) - strtotime($a['tarih']);
                });

                echo "<table>";
                echo "<tr>
                        <th>İsim Soyisim</th>
                        <th>Yaş Aralığı</th>
                        <th>İlişki Durumu</th>
                        <th>Partner Sorunu</th>
                        <th>Stres Seviyesi</th>
                        <th>Sorun Süresi</th>
                        <th>Sigara</th>
                        <th>Alkol</th>
                        <th>Cep Telefonu</th>
                        <th>Tarih</th>
                      </tr>";

                foreach ($veriler as $veri) {
                    echo "<tr>
                            <td>{$veri['isim_soyisim']}</td>
                            <td>{$veri['yas_araligi']}</td>
                            <td>{$veri['iliskidurumu']}</td>
                            <td>{$veri['partner_sorunu']}</td>
                            <td>{$veri['stres_seviyesi']}</td>
                            <td>{$veri['sorun_suresi']}</td>
                            <td>{$veri['sigara']}</td>
                            <td>{$veri['alkol']}</td>
                            <td>{$veri['cep_telefonu']}</td>
                            <td>{$veri['tarih']}</td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>JSON dosyası boş veya geçersiz.</p>";
            }
        } else {
            echo "<p>'datalar.json' dosyası bulunamadı.</p>";
        }

        if (isset($_POST['download'])) {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="datalar.xls"');
            echo "İsim Soyisim\tYaş Aralığı\tİlişki Durumu\tPartner Sorunu\tStres Seviyesi\tSorun Süresi\tSigara\tAlkol\tCep Telefonu\tTarih\n";
            foreach ($veriler as $veri) {
                echo "{$veri['isim_soyisim']}\t{$veri['yas_araligi']}\t{$veri['iliskidurumu']}\t{$veri['partner_sorunu']}\t{$veri['stres_seviyesi']}\t{$veri['sorun_suresi']}\t{$veri['sigara']}\t{$veri['alkol']}\t{$veri['cep_telefonu']}\t{$veri['tarih']}\n";
            }
            exit;
        }

        if (isset($_POST['delete'])) {
            file_put_contents($filePath, '[]');
            header("Refresh:0");
        }
        ?>
    </div>
</body>
</html>
