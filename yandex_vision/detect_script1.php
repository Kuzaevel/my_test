<?php

    function get_iam_token($iam_url, $oauth_token)
    {
        $send = ["yandexPassportOauthToken" => $oauth_token];
        $json = json_encode($send);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $iam_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $resp = curl_exec($ch);
        curl_close($ch);
        $out = json_decode($resp, true);
        return $out["iamToken"];
    }

    function request_analyze_custom($image_path) {
        $vision_url = 'https://vision.api.cloud.yandex.net/vision/v1/batchAnalyze';
        $iam_url = 'https://iam.api.cloud.yandex.net/iam/v1/tokens';
        $oauth_token = 'AgAAAAAGIhH1AATuwZCVhmQgv0FYjvHQwz-tZKs';
        $iam_token = get_iam_token($iam_url, $oauth_token);
        $image_data = base64_encode(file_get_contents($image_path));

        //$headers = json_encode(['Authorization'=>'Bearer ' + $iam_token]);

        $json = "{ 
            'folderId': 'b1g831971tek2mmkanv9',
            'analyzeSpecs': [
                {
                    'content': '$image_data',
                    'features': [
                        {
                            'type': 'TEXT_DETECTION',
                            'textDetectionConfig': {
                            'languageCodes': ['en', 'ru']
                            }
                        }
                    ],
                }
            ]
        }";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $vision_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $iam_token));
        $resp = curl_exec($ch);
        curl_close($ch);

        $out = json_decode($resp);
        return $out;

    }

$out = request_analyze_custom('resources/3.jpg');
echo "<pre>";
var_dump($out);
//var_dump($out[0]->results[0]->textDetection->pages[0]->blocks[0]->lines[0]->words[0]);
echo "</pre>";
