<?php

$dir = __DIR__ . '/public/assets/images/gallery';
if (file_exists($dir . '/gallery-1.jpg')) {
    copy($dir . '/gallery-1.jpg', $dir . '/story-1.jpg');
    copy($dir . '/gallery-2.jpg', $dir . '/story-2.jpg');
    copy($dir . '/gallery-3.jpg', $dir . '/story-3.jpg');
    copy($dir . '/gallery-4.jpg', $dir . '/story-4.jpg');
    echo "Story photos copied.\n";
}

// Generate an elegant QRIS SVG/PNG placeholder
$qrisSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
  <rect width="300" height="300" fill="#ffffff" rx="16" />
  <rect x="20" y="20" width="260" height="40" fill="#003366" rx="8" />
  <text x="150" y="47" fill="#ffffff" font-family="sans-serif" font-weight="bold" font-size="20" text-anchor="middle">QRIS - BCA DIGITAL</text>
  
  <!-- Outer Finder Patterns -->
  <rect x="40" y="80" width="60" height="60" fill="#000" />
  <rect x="48" y="88" width="44" height="44" fill="#fff" />
  <rect x="56" y="96" width="28" height="28" fill="#000" />

  <rect x="200" y="80" width="60" height="60" fill="#000" />
  <rect x="208" y="88" width="44" height="44" fill="#fff" />
  <rect x="216" y="96" width="28" height="28" fill="#000" />

  <rect x="40" y="200" width="60" height="60" fill="#000" />
  <rect x="48" y="208" width="44" height="44" fill="#fff" />
  <rect x="56" y="216" width="28" height="28" fill="#000" />

  <!-- QR Simulated Grid Matrix -->
  <g fill="#2F1B14">
    <rect x="120" y="80" width="12" height="12"/>
    <rect x="140" y="80" width="12" height="12"/>
    <rect x="170" y="80" width="12" height="12"/>
    <rect x="110" y="100" width="12" height="12"/>
    <rect x="130" y="100" width="12" height="12"/>
    <rect x="150" y="100" width="12" height="12"/>
    <rect x="180" y="100" width="12" height="12"/>

    <rect x="120" y="120" width="24" height="12"/>
    <rect x="150" y="120" width="12" height="12"/>
    <rect x="170" y="120" width="24" height="12"/>

    <rect x="40" y="150" width="12" height="12"/>
    <rect x="60" y="150" width="24" height="12"/>
    <rect x="90" y="150" width="12" height="12"/>
    <rect x="120" y="150" width="12" height="12"/>
    <rect x="140" y="150" width="24" height="12"/>
    <rect x="180" y="150" width="24" height="12"/>
    <rect x="220" y="150" width="12" height="12"/>
    <rect x="240" y="150" width="12" height="12"/>

    <rect x="120" y="180" width="12" height="12"/>
    <rect x="150" y="180" width="24" height="12"/>
    <rect x="180" y="180" width="12" height="12"/>

    <rect x="120" y="210" width="24" height="12"/>
    <rect x="160" y="210" width="12" height="12"/>
    <rect x="190" y="210" width="24" height="12"/>
    <rect x="220" y="210" width="12" height="12"/>
    <rect x="240" y="210" width="20" height="12"/>

    <rect x="110" y="240" width="12" height="12"/>
    <rect x="130" y="240" width="24" height="12"/>
    <rect x="170" y="240" width="12" height="12"/>
    <rect x="200" y="240" width="24" height="12"/>
    <rect x="240" y="240" width="20" height="12"/>
  </g>

  <!-- Center Badge -->
  <circle cx="150" cy="150" r="18" fill="#C6A15B" stroke="#ffffff" stroke-width="3" />
  <text x="150" y="155" fill="#2F1B14" font-family="serif" font-weight="bold" font-size="14" text-anchor="middle">AS</text>
  
  <text x="150" y="285" fill="#666666" font-family="sans-serif" font-size="11" text-anchor="middle">Arya Daniswara &amp; Sekar Kinanti</text>
</svg>';

file_put_contents(__DIR__ . '/public/assets/images/ornaments/qris-bca.svg', $qrisSvg);
echo "QRIS SVG generated.\n";
