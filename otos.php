<?php
    $counter = 0;
    $file = fopen('otos.csv', 'r');
    
    print('<table>');

    // Ameddig van sor
    while (!feof($file)) {
        
        // Ameddig nem lát egy entert
        $row = fgets($file);
    
        print '<tr>';
        
        // A sort feltöröm a ; mentén
        $arrayRow = explode(';', $row);

        for ($i = 0; $i < count($arrayRow); $i++) { 
            print '<td>' . $arrayRow[$i] . '</td>';
        }

        print '</tr>';
        $counter++;
    }

    print('</table>');
?>