<?php

$dirs = [
    __DIR__ . '/public/assets/images/couple',
    __DIR__ . '/public/assets/images/gallery',
    __DIR__ . '/public/assets/audio',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

$filesToCopy = [
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/62db9c61-aa55-414c-9bae-891eb0a80ce2/javanese_bride_portrait_1791815644988.jpg' => __DIR__ . '/public/assets/images/couple/bride.jpg',
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/62db9c61-aa55-414c-9bae-891eb0a80ce2/javanese_groom_portrait_1791815666141.jpg' => __DIR__ . '/public/assets/images/couple/groom.jpg',
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/62db9c61-aa55-414c-9bae-891eb0a80ce2/javanese_couple_prewedding_1791815686008.jpg' => __DIR__ . '/public/assets/images/couple/hero.jpg',
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/62db9c61-aa55-414c-9bae-891eb0a80ce2/javanese_couple_prewedding_1791815686008.jpg' => __DIR__ . '/public/assets/images/gallery/gallery-1.jpg',
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/ef3b90cd-25ae-4f10-9cbc-c4ec720af8cd/javanese_wedding_rings_1791815759744.jpg' => __DIR__ . '/public/assets/images/gallery/gallery-2.jpg',
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/ef3b90cd-25ae-4f10-9cbc-c4ec720af8cd/javanese_pendopo_joglo_1791815784143.jpg' => __DIR__ . '/public/assets/images/gallery/gallery-3.jpg',
    'C:/Users/AGUSTIAN/.gemini/antigravity-ide/brain/ef3b90cd-25ae-4f10-9cbc-c4ec720af8cd/javanese_siraman_ceremony_1791815806013.jpg' => __DIR__ . '/public/assets/images/gallery/gallery-4.jpg',
    __DIR__ . '/public/assets/images/couple/bride.jpg' => __DIR__ . '/public/assets/images/gallery/gallery-5.jpg',
    __DIR__ . '/public/assets/images/couple/groom.jpg' => __DIR__ . '/public/assets/images/gallery/gallery-6.jpg',
];

foreach ($filesToCopy as $src => $dst) {
    if (file_exists($src)) {
        copy($src, $dst);
        echo "Copied " . basename($src) . " -> " . basename($dst) . "\n";
    } else {
        echo "Source missing: " . $src . "\n";
    }
}

echo "All copy operations complete.\n";
