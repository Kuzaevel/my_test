<?php
//namespace Google\Cloud\Samples\Vision;
require("vendor/autoload.php");
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

function detect_text($path)
{
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->textDetection($image);
    $texts = $response->getTextAnnotations();

    printf('%d texts found:' . "\r\n", count($texts));
    print("\r\n");

    foreach ($texts as $text) {
        print($text->getDescription() . "\r\n");
        print("\r\n");

        # get bounds
        $vertices = $text->getBoundingPoly()->getVertices();
        $bounds = [];
        foreach ($vertices as $vertex) {
            $bounds[] = sprintf('(%d,%d)', $vertex->getX(), $vertex->getY());
        }
        print('Bounds: ' . join(', ', $bounds) . "\r\n");
        print("\r\n");
    }

    $imageAnnotator->close();
}

function boundsDraw($filename, $coordinates)
{
    $info = getimagesize($filename);
    $path_info = pathinfo($filename);

    $type = $info[2];

    switch ($type) {
        case 1:
            $img = imageCreateFromGif($filename);
            imageSaveAlpha($img, true);
            break;
        case 2:
            $img = imageCreateFromJpeg($filename);
            break;
        case 3:
            $img = imageCreateFromPng($filename);
            imageSaveAlpha($img, true);
            break;
    }

    $orange = imagecolorallocate($img, 255, 200, 0);
    imagesetthickness($img, 2);
    foreach ($coordinates as $coordinate) {
//        imagerectangle($img, $coordinate["x1"], $coordinate["y1"], $coordinate["x2"], $coordinate["y2"], $orange);
        imageline ($img, $coordinate[0], $coordinate[1], $coordinate[2], $coordinate[3], $orange );
        imageline ($img, $coordinate[2], $coordinate[3], $coordinate[4], $coordinate[5], $orange );
        imageline ($img, $coordinate[4], $coordinate[5], $coordinate[6], $coordinate[7], $orange );
        imageline ($img, $coordinate[6], $coordinate[7], $coordinate[0], $coordinate[1], $orange );
    }
    $src = $path_info["dirname"] . "/" . $path_info["filename"] . "_tmp" . "." . $path_info["extension"];
    imagePng($img, $src);
    imagedestroy($img);
    return $src;
}

function detect_text_custom($path)
{
    $out = [];
    $coordinates = [];
//    return null;
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->textDetection($image);
    $texts = $response->getTextAnnotations();
    //$out .= count($texts) - 1 . ' texts found:' . "<br>";
    $i = 0;
    foreach ($texts as $text) {
        if ($i == 0) {
            $out_all_texts = explode(" - Bounds: ", $text->getDescription());
//            $out .= "   " . $out_all_texts[0] . "<br>";
//            array_push($out,  "   " . $out_all_texts[0]);
        } else {
//            $out .= $i . ") " . $text->getDescription() . " - ";
            $out_txt = $text->getDescription() . " - ";
            # get bounds
            $vertices = $text->getBoundingPoly()->getVertices();
            $bounds = [];
            $j = 0;
            $co = [];
            foreach ($vertices as $vertex) {
                $bounds[] = sprintf('(%d,%d)', $vertex->getX(), $vertex->getY());
                array_push( $co, $vertex->getX());
                array_push( $co, $vertex->getY());
//                if($j == 0 ){
//                    $co["x1"] = $vertex->getX();
//                    $co["y1"] = $vertex->getY();
//                }
//                if($j == 2) {
//                    if($co["x1"] < $vertex->getX()) {
//                        $co["x2"] = $co["x1"];
//                    } else {
//                        $co["x1"] = $vertex->getX();
//                        $co["x2"] = $vertex->getX();
//                    }
//                    if($co["y1"] > $co["y2"]) {
//
//                    } else {
//                        $co["y2"] = $vertex->getY();
//                    }
//                }
//                $j++;
            }
//            $out .= 'Bounds: ' . join(', ', $bounds) . "<br>";
            array_push($out,  $out_txt . 'Bounds: ' . join(', ', $bounds));
            array_push($coordinates, $co);
        }
        $i++;
    }

    $imageAnnotator->close();
    return array("out"=>$out, "coordinates"=>$coordinates);
}


$json = file_get_contents('php://input');
$data = json_decode($json);

$arr = detect_text_custom($data->img_path);
$out = $arr["out"];
$coordinates = $arr["coordinates"];
$src = boundsDraw($data->img_path, $coordinates);
header('Content-Type: application/json');
echo json_encode(array("text" =>$out, "src"=>$src));