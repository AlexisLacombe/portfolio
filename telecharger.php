<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Télécharger les fichiers - Portfolio SI</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg-1: #0f0620;
      --bg-2: #0b1b2b;
      --accent: #7c5cff;
      --accent-2: #00d2ff;
      --success: #00d9a3;
      --card-bg: rgba(255,255,255,0.03);
      --text: #e9eef8;
      --muted: #98a0b3;
      --radius: 14px;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
      color:var(--text);
      background: radial-gradient(1200px 600px at 10% 10%, rgba(124,92,255,0.12), transparent 8%),
                  radial-gradient(1000px 500px at 95% 90%, rgba(0,210,255,0.06), transparent 6%),
                  linear-gradient(180deg, var(--bg-1) 0%, var(--bg-2) 100%);
      -webkit-font-smoothing:antialiased;
      padding:36px;
      min-height:100vh;
    }

    .container{
      max-width:1000px;
      margin:0 auto;
    }

    .header{
      background:rgba(255,255,255,0.02);
      border:1px solid rgba(255,255,255,0.04);
      border-radius:var(--radius);
      backdrop-filter:blur(8px);
      padding:24px;
      margin-bottom:32px;
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:16px;
    }

    h1{
      margin:0;
      font-size:24px;
      background: linear-gradient(135deg,var(--accent),var(--accent-2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .back-btn{
      padding:10px 20px;
      border-radius:10px;
      background:rgba(255,255,255,0.06);
      border:1px solid rgba(255,255,255,0.1);
      color:var(--text);
      text-decoration:none;
      font-weight:600;
      font-size:14px;
      transition:all 0.2s ease;
      display:inline-flex;
      align-items:center;
      gap:8px;
    }

    .back-btn:hover{
      background:rgba(255,255,255,0.1);
      transform:translateX(-4px);
    }

    .files-grid{
      display:grid;
      gap:16px;
    }

    .file-card{
      background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
      border: 1px solid rgba(255,255,255,0.05);
      border-radius:var(--radius);
      padding:20px;
      display:flex;
      align-items:center;
      gap:16px;
      transition:all 0.3s ease;
    }

    .file-card:hover{
      background: rgba(255,255,255,0.05);
      border-color:rgba(124,92,255,0.3);
      transform:translateX(8px);
      box-shadow: 0 8px 32px rgba(124,92,255,0.15);
    }

    .file-icon{
      width:56px;
      height:56px;
      border-radius:12px;
      background:linear-gradient(135deg,var(--accent),var(--accent-2));
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:24px;
      flex-shrink:0;
      box-shadow: 0 6px 20px rgba(124,92,255,0.2);
    }

    .file-info{
      flex:1;
      min-width:0;
    }

    .file-name{
      font-weight:600;
      font-size:16px;
      margin:0 0 6px 0;
      color:var(--text);
      word-break:break-all;
    }

    .file-meta{
      display:flex;
      gap:16px;
      font-size:13px;
      color:var(--muted);
    }

    .download-btn{
      padding:12px 24px;
      border-radius:10px;
      background:linear-gradient(90deg,var(--accent),var(--accent-2));
      color:#04101a;
      font-weight:600;
      text-decoration:none;
      box-shadow: 0 6px 18px rgba(124,92,255,0.12);
      transition:all 0.2s ease;
      border:none;
      cursor:pointer;
      font-size:14px;
      white-space:nowrap;
    }

    .download-btn:hover{
      transform:scale(1.05);
      box-shadow: 0 8px 24px rgba(124,92,255,0.24);
    }

    .stats-bar{
      background:rgba(255,255,255,0.02);
      border:1px solid rgba(255,255,255,0.04);
      border-radius:var(--radius);
      padding:16px 24px;
      margin-bottom:24px;
      display:flex;
      justify-content:space-between;
      align-items:center;
      flex-wrap:wrap;
      gap:16px;
    }

    .stat-item{
      display:flex;
      align-items:center;
      gap:8px;
      font-size:14px;
      color:var(--muted);
    }

    .stat-value{
      color:var(--accent-2);
      font-weight:600;
    }

    .empty-state{
      text-align:center;
      padding:60px 20px;
      background:rgba(255,255,255,0.02);
      border:2px dashed rgba(255,255,255,0.1);
      border-radius:var(--radius);
    }

    .empty-icon{
      font-size:64px;
      margin-bottom:16px;
      opacity:0.5;
    }

    .empty-text{
      color:var(--muted);
      font-size:16px;
      margin:0;
    }

    @media (max-width:768px){
      body{padding:20px}
      .header{flex-direction:column; text-align:center}
      .file-card{flex-direction:column; text-align:center}
      .file-meta{justify-content:center; flex-wrap:wrap}
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>📁 Travaux Demandés</h1>
      <a href="index.html" class="back-btn">← Retour au portfolio</a>
    </div>

    <?php
    // Configuration
    $dir = 'fichiers/';
    
    // Fonction pour obtenir l'icône
    function getFileIcon($filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $icons = [
            'pdf' => '📄',
            'doc' => '📝', 'docx' => '📝',
            'xls' => '📊', 'xlsx' => '📊',
            'ppt' => '📊', 'pptx' => '📊',
            'zip' => '🗜️', 'rar' => '🗜️', '7z' => '🗜️',
            'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️', 'gif' => '🖼️',
            'mp4' => '🎬', 'avi' => '🎬', 'mkv' => '🎬',
            'mp3' => '🎵', 'wav' => '🎵',
            'txt' => '📋',
            'py' => '🐍',
            'html' => '🌐', 'css' => '🎨', 'js' => '⚡',
        ];
        return $icons[$ext] ?? '📁';
    }
    
    // Fonction pour formater la taille
    function formatBytes($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' Go';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' Mo';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' Ko';
        } else {
            return $bytes . ' octets';
        }
    }
    
    // Vérifier si le dossier existe
    if (!is_dir($dir)) {
        echo '<div class="empty-state">
                <div class="empty-icon">📂</div>
                <p class="empty-text">Le dossier "fichiers" n\'existe pas.</p>
              </div>';
        echo '</div></body></html>';
        exit;
    }
    
    // Récupérer tous les fichiers
    $files = [];
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $filePath = $dir . $item;
        if (is_file($filePath)) {
            $files[] = [
                'name' => $item,
                'size' => filesize($filePath),
                'date' => filemtime($filePath)
            ];
        }
    }
    
    // Si aucun fichier
    if (empty($files)) {
        echo '<div class="empty-state">
                <div class="empty-icon">📭</div>
                <p class="empty-text">Aucun fichier dans le dossier "fichiers".</p>
              </div>';
        echo '</div></body></html>';
        exit;
    }
    
    // Trier par date (plus récent en premier)
    usort($files, function($a, $b) {
        return $b['date'] - $a['date'];
    });
    
    // Calculer les stats
    $totalSize = array_sum(array_column($files, 'size'));
    $fileCount = count($files);
    ?>

    <div class="stats-bar">
      <div class="stat-item">
        <span>📦 Fichiers totaux :</span>
        <span class="stat-value"><?= $fileCount ?></span>
      </div>
      <div class="stat-item">
        <span>💾 Taille totale :</span>
        <span class="stat-value"><?= formatBytes($totalSize) ?></span>
      </div>
    </div>

    <div class="files-grid">
      <?php foreach ($files as $file): ?>
        <div class="file-card">
          <div class="file-icon"><?= getFileIcon($file['name']) ?></div>
          <div class="file-info">
            <p class="file-name"><?= htmlspecialchars($file['name']) ?></p>
            <div class="file-meta">
              <span>📏 <?= formatBytes($file['size']) ?></span>
              <span>📅 <?= date('d/m/Y', $file['date']) ?></span>
            </div>
          </div>
          <a href="<?= $dir . urlencode($file['name']) ?>" class="download-btn" download>
            ⬇️ Télécharger
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>