<?php
    $file = fopen('otos.csv', 'r');

    // A nyerőszámok
    $szamok = array();

    // Ameddig van sor
    while (!feof($file)) {
        
        // Ameddig nem lát egy entert
        $row = fgets($file);
        
        // A sort feltöröm a ; mentén
        $arrayRow = explode(';', $row);
        $meret = count($arrayRow);

        if ($meret > 15) {
            
            // A nyerőszámok
            $mostaniSzamok = array(
                $arrayRow[$meret - 5],
                $arrayRow[$meret - 4],
                $arrayRow[$meret - 3],
                $arrayRow[$meret - 2],
                $arrayRow[$meret - 1]
            );

            $szamok[] = $mostaniSzamok;
        }
       
    }

    fclose($file);

    // Feltölti a tömböt 90 db 0-val
    $huzasok = array_fill(0, 91, 0);

    // Feltöltjük a tömböt adatokkal
    for ($i = 0; $i < count($szamok); $i++) { 
        for ($j = 0; $j < count($szamok[$i]); $j++) { 
            
            // Valahányadik sora
            $huzasok[(int) $szamok[$i][$j] ]++;
        }
    }

    // Sorbarendezi
    // A legnagyobb a legvégére került
    asort($huzasok);

    $nagyok = array();

    for ($i = 0; $i < 5; $i++) { 
        $nagyok[] = array(array_key_last($huzasok), array_pop($huzasok));
    }

    //print_r($nagyok);

    header('Content-Type: image/png');

    $hossz = 500;
    $kep = imagecreatetruecolor($hossz, $hossz);

    $piros1 = imagecolorallocate($kep, 255, 0, 0);
    $piros2 = imagecolorallocate($kep, 200, 0, 0);

    $sarga1 = imagecolorallocate($kep, 255, 255, 0);
    $sarga2 = imagecolorallocate($kep, 200, 200, 0);

    $zold1 = imagecolorallocate($kep, 0, 255, 0);
    $zold2 = imagecolorallocate($kep, 0, 200, 0);

    $cian1 = imagecolorallocate($kep, 0, 255, 255);
    $cian2 = imagecolorallocate($kep, 0, 200, 200);

    $kek1 = imagecolorallocate($kep, 0, 0, 255);
    $kek2 = imagecolorallocate($kep, 0, 0, 200);

    $feher1 = imagecolorallocate($kep, 255, 255, 255);

    // Körcikk vonal
    // imagearc($kep, 250, 250, 100, 100, 0, 90, $piros1);

    // Kitöltött körcikk
    // imagefilledarc($kep, 250, 250, 100, 100, 0, 90, $piros1, IMG_ARC_PIE);

    $osszeg = 0;

    for ($i = 0; $i < count($nagyok); $i++) {
        $osszeg += $nagyok[$i][1];
    }

    // Letároljuk a világosabb színeket
    $vilagosSzinek = array($piros1, $sarga1, $zold1, $cian1, $kek1);

    // Letároljuk a sötétebb színeket
    $sotetSzinek = array($piros2, $sarga2, $zold2, $cian2, $kek2);

    $vegSzog = 0;

    // 20 réteget egymásra pakol
    for ($k = 0; $k < 20; $k++) { 
        $kezdoSzog = 0;
        for ($i = 0; $i < count($nagyok); $i++) { 
        
            $vegSzog = (int) ($kezdoSzog + ($nagyok[$i][1] / $osszeg) * 360);
    
            // Kirajzoljuk a körcikkeket a világos színekkel
            imagefilledarc($kep, 250, 250 - $k, 200, 100, $kezdoSzog, $vegSzog, $vilagosSzinek[$i], IMG_ARC_PIE);
            
            $kezdoSzog = $vegSzog;
        }
    }

    $kezdoSzog = 0;
    
    // A felső sötétebb réteg
    for ($i = 0; $i < count($nagyok); $i++) { 
    
        $vegSzog = (int) ($kezdoSzog + ($nagyok[$i][1] / $osszeg) * 360);

        // Kirajzoljuk a körcikkeket a sötét színekkel
        imagefilledarc($kep, 250, 250 - $k, 200, 100, $kezdoSzog, $vegSzog,$sotetSzinek[$i], IMG_ARC_PIE);
        
        $kezdoSzog = $vegSzog;
    }

    imagepng($kep);
    imagedestroy($kep);

?>