<?php
require 'vendor/autoload.php';

use Google\Cloud\Vision\VisionClient;

$vision = new VisionClient();

// Annotate an image, detecting faces.
$image = $vision->image(
//    fopen('/data/family_photo.jpg', 'r'),
    fopen('resources/test_vision.png', 'r'),
    ['faces']
);

$annotation = $vision->annotate($image);

// Determine if the detected faces have headwear.
foreach ($annotation->faces() as $key => $face) {
    if ($face->hasHeadwear()) {
        echo "Face $key has headwear.\n";
    }
}