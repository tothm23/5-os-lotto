<?php 

header("content-type: image/png");

$img = imagecreatetruecolor(800, 500);

// A színek
$black = imagecolorallocate($img, 0, 0, 0);
$white = imagecolorallocate($img, 255, 255, 255);

$blueLight = imagecolorallocate($img, 0, 0, 255);
$blueDark = imagecolorallocate($img, 0, 0, 200);

$greenLight = imagecolorallocate($img, 0, 255, 0);
$greenDark = imagecolorallocate($img, 0, 200, 0);

$redLight = imagecolorallocate($img, 255, 0, 0);
$redDark = imagecolorallocate($img, 200, 0, 0);

// A 3 fehér vonal
imageline($img, 50, 450, 750, 450, $white);
imageline($img, 50, 50, 50, 450, $white);
imageline($img, 450, 50, 50, 450, $white);

// Az adatokat tartalmazó tömb
$data = array(300, 250, 291, 350, 105, 70, 399);

// A tömb átlaga, legkisebb és legnegyobb értéke
$average = array_sum($data) / count($data);
$min = min($data);
$max = max($data);

// A 20 világos réteg
for ($j = 0; $j < 20; $j++) { 
    for ($i = 0; $i < count($data); $i++) {
        $startX = $i * 100 + 75; 
        $endX = $startX + 50;
        $endY = 449;
        $startY = $endY - $data[$i];
    
        // Az átlag felettiek vörösek, a többi zöld
        if ($data[$i] >= $average) {
            imagefilledrectangle($img, $startX + $j, $startY - $j, $endX + $j, $endY - $j, $redLight);
        }else{
            imagefilledrectangle($img, $startX + $j, $startY - $j, $endX + $j, $endY - $j, $greenLight);
        }
    }
}

// A felső sötét réteg
for ($i = 0; $i < count($data); $i++) { 
    $startX = $i * 100 + 75; 
    $endX = $startX + 50;
    $endY = 449;
    $startY = $endY - $data[$i];

    // Az átlag felettiek vörösek, a többi zöld
    if ($data[$i] >= $average) {
        imagefilledrectangle($img, $startX, $startY, $endX, $endY, $redDark);
    }else{
        imagefilledrectangle($img, $startX, $startY, $endX, $endY, $greenDark);
    }

    // A tömb értékei
    imagestring($img, 5, $startX + 12.5, 460, $data[$i], $white);
}

// Az átlagnál lévő kék vonal
// imageline($img, 50, $average, 750, $average, $blue);

// imagestring($img, 10, 10, 5, "Minimum: " . $min, $white);
// imagestring($img, 10, 10, 20, "Atlag: " . $average, $white);
// imagestring($img, 10, 10, 35, "Maximum: " . $max, $white);
imagepng($img);
imagedestroy($img);

?>