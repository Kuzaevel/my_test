<?php

class Alarmer
{

    /**
     * Отправляет уведомление
     * @param string $key - ваш API-KEY
     * @param string $message - сообщение
     */


    static public function send($key, $message)
    {
        $ch = curl_init("https://alarmerbot.ru/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "key" => $key,
            "message" => $message,
        ));
        curl_exec($ch);
        curl_close($ch);
    }

    static public function send_message($message)
    {
        $key = "060548-d9c48c-b2567f";
        $ch = curl_init("https://alarmerbot.ru/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "key" => $key,
            "message" => $message,
        ));
        curl_exec($ch);
        curl_close($ch);
    }

}
