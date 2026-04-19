$productNames = @(
  'kopi_susu_gula_aren',
  'croissant_butter',
  'biji_kopi_arabica_gayo',
  'kopi_lokal',
  'arabica_gayo',
  'gula_aren',
  'bakeri_segar'
)
$aboutNames = @('bahan_segar','petani_lokal','pesan_online','bawa_pulang')

$lines = [System.Collections.Generic.List[string]]::new()
$lines.Add('// AUTO-GENERATED — gambar base64 untuk Figma Scripter')
$lines.Add('const IMAGES = {')

foreach ($name in $productNames) {
  $path = "c:\dev\kafetani\assets\img\products\$name.webp"
  if (Test-Path $path) {
    $bytes = [System.IO.File]::ReadAllBytes($path)
    $b64 = [System.Convert]::ToBase64String($bytes)
    $lines.Add("  `"$name`": `"data:image/webp;base64,$b64`",")
    Write-Host "OK products/$name ($($bytes.Length) bytes)"
  }
}

foreach ($name in $aboutNames) {
  $path = "c:\dev\kafetani\assets\img\about\$name.webp"
  if (Test-Path $path) {
    $bytes = [System.IO.File]::ReadAllBytes($path)
    $b64 = [System.Convert]::ToBase64String($bytes)
    $lines.Add("  `"about_$name`": `"data:image/webp;base64,$b64`",")
    Write-Host "OK about/$name ($($bytes.Length) bytes)"
  }
}

$lines.Add('};')

$output = $lines -join "`n"
[System.IO.File]::WriteAllText('c:\dev\kafetani\figma_images.js', $output, [System.Text.Encoding]::UTF8)
Write-Host "Selesai! Ditulis ke figma_images.js"
