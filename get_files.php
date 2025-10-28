<?php
header('Content-Type: application/json');

$dir = 'fichiers/';

// Vérifier que le dossier existe
if (!is_dir($dir)) {
    echo json_encode([
        'success' => false,
        'message' => 'Le dossier fichiers n\'existe pas',
        'files' => [],
        'totalSize' => 0
    ]);
    exit;
}

// Récupérer tous les fichiers
$files = array_diff(scandir($dir), array('.', '..'));
$fileList = [];
$totalSize = 0;

foreach ($files as $file) {
    $filePath = $dir . $file;
    
    // Ne prendre que les fichiers (pas les dossiers)
    if (is_file($filePath)) {
        $fileSize = filesize($filePath);
        $totalSize += $fileSize;
        
        $fileList[] = [
            'name' => $file,
            'size' => $fileSize,
            'modified' => filemtime($filePath)
        ];
    }
}

// Trier par date de modification (plus récent en premier)
usort($fileList, function($a, $b) {
    return $b['modified'] - $a['modified'];
});

echo json_encode([
    'success' => true,
    'files' => $fileList,
    'totalSize' => $totalSize
]);
?>