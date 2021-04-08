<?php

// cmd: php 1_search.php menu

$stringData = [];

$i = 0;
foreach(file('1_string.csv') as $line) {
	$lineAr = explode( ";", $line, 3);
    if(count($lineAr) == 3) {
        foreach ($lineAr as $k => $v) {
            $li = $v;

            if($k == 1) {
                $li = preg_replace("/\(/", "\(", $li);
                $li = preg_replace("/\)/", "\)", $li);
                $li = preg_replace("/\//", "\/", $li);

                $li = preg_replace("/\"\"/", "&&&", $li);
                $li = preg_replace("/\"/", "", $li);
                $li = preg_replace("/&&&/", "\"", $li);
            }

            $lineAr[$k] = $li;

//            if (preg_match("/\"\"/", $v)) {
//                $li = preg_replace("/\"\"/", "&&&", $v);
//                $li = preg_replace("/\"/", "", $li);
//                $li = preg_replace("/&&&/", "\"", $li);
//                //echo $li . "\r\n";
//                $lineAr[$k] = $li;
//            }

        }
        $stringData[$lineAr[1]] = $lineAr[2];
    }
}


//foreach ($stringData as $key=>$val) {
//   echo $key . '::' . $val . "\r\n";
//}
//die();



$filename = $argv[1]. '.php';
ss1($filename, $stringData);


function ss1($filename, $stringData) {
    $changes = false;
    $i = 0;

    $ff = file_get_contents($filename);

    foreach ($stringData as $k => $v) {
        $findstr = "/'" . trim($k) . "'/";
        echo $findstr . "\n";

        if (preg_match($findstr, $ff)) {
            $ff = preg_replace($findstr,  "'" . trim($v) . "'", $ff);
            $changes = true;
            $i++;
        }
    }

    if($changes) {

        echo $ff;

        $fp = fopen($filename, "w");
        fwrite($fp, $ff);
        fclose($fp);
        echo "success count::" . $i;
    }
}



?>
