<?php
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$feedback = $_POST['feedback'] ?? null;

if ($name && $email && $feedback) {
    $newEntry = [
        'name' => $name,
        'email' => $email,
        'feedback' => $feedback,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    $filePath = 'data.json';
    $data = [];

    if (file_exists($filePath)) {
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true) ?? [];
    }

    $data[] = $newEntry;

    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

    header('Location: index.php?basarili=1');
    exit;
} else {
    header('Location: index.php?basarili=0');
    exit;
}
?>
<?php
/// developer by @mustollah
?>