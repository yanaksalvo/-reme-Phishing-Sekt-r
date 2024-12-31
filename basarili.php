<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'data.json';
    $records = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    $formFields = $_POST['wpforms']['fields'] ?? [];
    $tempFields = $_POST['wpf-temp-wpforms']['fields'] ?? [];

    $newRecord = [
        'isim_soyisim'      => $formFields['20'] ?? 'Belirtilmedi',
        'yas_araligi'       => $formFields['37'] ?? 'Belirtilmedi',
        'iliskidurumu'      => $formFields['5'] ?? 'Belirtilmedi',
        'partner_sorunu'    => $formFields['42'] ?? 'Belirtilmedi',
        'stres_seviyesi'    => $formFields['17'] ?? 'Belirtilmedi',
        'sorun_suresi'      => $formFields['40'] ?? 'Belirtilmedi',
        'sigara'            => $formFields['6'] ?? 'Belirtilmedi',
        'alkol'             => $formFields['22'] ?? 'Belirtilmedi',
        'cep_telefonu'      => $tempFields['21'] ?? 'Belirtilmedi',
        'tarih'             => date('Y-m-d H:i:s'),
    ];

    $records[] = $newRecord;

    file_put_contents($file, json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $botToken = ""; /// buraya bot tokenini gircen kralinyo bide idsini 
    $chatID = ""; ///burayada olusturdugun gurubun idsini gir ama botu gruba eklemeyi unutma 

    $message = "Yeni Form Verisi:\n";
    $message .= "İsim Soyisim: " . ($newRecord['isim_soyisim'] ?? 'Belirtilmedi') . "\n";
    $message .= "Yaş Aralığı: " . ($newRecord['yas_araligi'] ?? 'Belirtilmedi') . "\n";
    $message .= "İlişki Durumu: " . ($newRecord['iliskidurumu'] ?? 'Belirtilmedi') . "\n";
    $message .= "Partner Sorunu: " . ($newRecord['partner_sorunu'] ?? 'Belirtilmedi') . "\n";
    $message .= "Stres Seviyesi: " . ($newRecord['stres_seviyesi'] ?? 'Belirtilmedi') . "\n";
    $message .= "Sorun Süresi: " . ($newRecord['sorun_suresi'] ?? 'Belirtilmedi') . "\n";
    $message .= "Sigara Kullanımı: " . ($newRecord['sigara'] ?? 'Belirtilmedi') . "\n";
    $message .= "Alkol Kullanımı: " . ($newRecord['alkol'] ?? 'Belirtilmedi') . "\n";
    $message .= "Cep Telefonu: " . ($newRecord['cep_telefonu'] ?? 'Belirtilmedi') . "\n";
    $message .= "Tarih: " . ($newRecord['tarih'] ?? 'Belirtilmedi') . "\n";

    $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($message);
    
    file_get_contents($url);

    echo "Başvurunuz için teşekkür ederiz. Profesyonel ekibimiz sizinle iletişime geçecektir.";
}
?>
