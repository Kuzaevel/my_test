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

function detect_text_custom($path)
{
    $out = "";
//    return null;
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->textDetection($image);

    $texts = $response->getTextAnnotations();
    return $texts;

    $out .= count($texts) - 1 . ' texts found:' . "<br>";
    $i = 0;
    foreach ($texts as $text) {
        if ($i == 0) {
            $out_all_texts = explode(" - Bounds: ", $text->getDescription());
            $out .= "   " . $out_all_texts[0] . "<br>";
        } else {
            $out .= $i . ") " . $text->getDescription() . " - ";
            # get bounds
            $vertices = $text->getBoundingPoly()->getVertices();
            $bounds = [];
            foreach ($vertices as $vertex) {
                $bounds[] = sprintf('(%d,%d)', $vertex->getX(), $vertex->getY());
            }
            $out .= 'Bounds: ' . join(', ', $bounds) . "<br>";
        }
        $i++;
    }

    $imageAnnotator->close();
    return $out;
}
echo '<pre>';
    var_dump(detect_text_custom('resources/3.jpg'));
echo '</pre>';