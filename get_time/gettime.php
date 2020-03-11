<?php

header('Access-Control-Allow-Origin: http://1csql-srv.novomet.ru');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json);


$servername = "localhost";
$username = "root";
$password = "";
$database = "GetTransport";


try {
    $conn = new PDO("mysql:host=$servername;dbname=".$database.";charset=utf8", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET CHARACTER SET utf8;");

}
catch(PDOException $e)
{
    die( $e->getMessage() ) ;
}

require_once "Alarmer.php";

if($data->answer) {

    setlocale(LC_ALL, 'ru_RU');

    // если будни
    if(date("w") > 0 AND date("w") < 6 ) {
        if ($data->answer == "Morning_BAD") {
            // эти сообщения отправляем без проверки существования в базе (с повтором)
            Alarmer::send_message("Вы не отметились при входе." . date("l j.m"));
        }
        if ($data->answer == "Evening_BAD") {
            // эти сообщения отправляем без проверки существования в базе (с повтором)
            Alarmer::send_message("Вы не отметились при выходе." . date("l j.m"));
        }
    }

    $count = 0;
    $sql = "SELECT COUNT(*) AS count
                FROM getTime 
            WHERE DATE(`time`) = CURDATE() AND `data` LIKE :data";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
        ":data" => $data->answer
    ));
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    if($count == 0) {

        $input = explode(",", $data->answer) ;
        if (trim($input[0]) == "Morning_Good") {
            $mes = "Время входа на проходной " . date("l j.m") . $input[1];
            Alarmer::send_message($mes);
        } else if (trim($input[0]) == "Evening_Good"){
            $mes = "Время выхода на проходной " . date("l j.m") . $input[1];
            Alarmer::send_message($mes);
        } else if (trim($input[0]) == "Worked_time"){
			$mes = "Отработано за день " . date("l j.m") . " :" . $input[1];
			Alarmer::send_message($mes);
		}

        $sql = "INSERT INTO getTime (data, time) VALUES (:data, NOW()); ";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(
            ":data" => $data->answer
        ));
    } else {
        $mes = "Запись уже добавлена в базу";
    }
}

$response = array(
    "data" => $data->answer,
    "weekday" => date("w") > 0 AND date("w") < 6,
    "message" => $mes
);

echo json_encode($response);