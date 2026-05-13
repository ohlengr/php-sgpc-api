<?php
// 1. Allow mobile apps and web apps to read this API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$cacheFile = __DIR__ . '/sgpc_cache.json';
$cacheTime = 3600; // 1 Hour cache in seconds

// 2. The Safety Net (Fallbacks in case the SGPC site is down)
$links = [
    'liveKirtan' => 'https://live.sgpc.net:8442/;',
    'dailyHukamnama' => 'https://hs.sgpc.net/uploadhukamnama/hukamnama.mp3'
];

// 3. Check the Cache First
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
    echo file_get_contents($cacheFile);
    exit;
}

// 4. Scrape the SGPC Website
$html = @file_get_contents('https://sgpc.net/');

if ($html !== false) {
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    libxml_clear_errors();

    $audioTags = $dom->getElementsByTagName('audio');
    
    foreach ($audioTags as $audio) {
        $sources = $audio->getElementsByTagName('source');
        foreach ($sources as $source) {
            $src = $source->getAttribute('src');
            
            // Extract Live Kirtan link
            if (strpos($src, 'live.sgpc.net') !== false) {
                $parts = explode(';nocache', $src);
                $links['liveKirtan'] = $parts[0] . ';';
            }
            
            // Extract Hukamnama link
            if (strpos($src, 'hukamnama.mp3') !== false) {
                $links['dailyHukamnama'] = $src;
            }
        }
    }
}

// 5. Format the Response
$response = json_encode([
    'success' => true,
    'links' => $links,
    'lastUpdated' => date('c')
]);

// 6. Save cache and serve
file_put_contents($cacheFile, $response);
echo $response;
?>
