<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Essayer différents chemins possibles
$possiblePaths = [
    'fichiers/',
    './fichiers/',
    '../fichiers/',
    __DIR__ . '/fichiers/'
];

$dir = null;
$usedPath = null;

// Trouver le bon chemin
foreach ($possiblePaths as $path) {
    if (is_dir($path)) {
        $dir = $path;
        $usedPath = $path;
        break;
    }
}

// Si aucun dossier trouvé
if ($dir === null) {
    echo json_encode([
        'success' => false,
        'message' => 'Le dossier fichiers n\'existe pas',
        'debug' => [
            'current_dir' => getcwd(),
            'script_dir' => __DIR__,
            'tried_paths' => $possiblePaths
        ],
        'files' => [],
        'totalSize' => 0
    ]);
    exit;
}

// Récupérer tous les fichiers
$allItems = scandir($dir);
$files = [];

foreach ($allItems as $item) {
    // Ignorer . et ..
    if ($item === '.' || $item === '..') {
        continue;
    }
    
    $filePath = $dir . $item;
    
    // Ne prendre que les fichiers (pas les dossiers)
    if (is_file($filePath)) {
        $files[] = $item;
    }
}

// Si aucun fichier trouvé
if (empty($files)) {
    echo json_encode([
        'success' => false,
        'message' => 'Aucun fichier trouvé dans le dossier',
        'debug' => [
            'folder_path' => $usedPath,
            'folder_exists' => true,
            'all_items' => $allItems,
            'file_count' => 0
        ],
        'files' => [],
        'totalSize' => 0
    ]);
    exit;
}

$fileList = [];
$totalSize = 0;

foreach ($files as $file) {
    $filePath = $dir . $file;
    $fileSize = filesize($filePath);
    $totalSize += $fileSize;
    
    $fileList[] = [
        'name' => $file,
        'size' => $fileSize,
        'modified' => filemtime($filePath)
    ];
}

// Trier par date de modification (plus récent en premier)
usort($fileList, function($a, $b) {
    return $b['modified'] - $a['modified'];
});

echo json_encode([
    'success' => true,
    'files' => $fileList,
    'totalSize' => $totalSize,
    'debug' => [
        'folder_path' => $usedPath,
        'file_count' => count($fileList)
    ]
]);
?>