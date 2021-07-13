<?php
class ServiceController extends MyCController
{

    public function actionTest()
    {
        $flagTradersFile = false;
        $flagAccountsFile = false;
        $flagLeadsSqlFile = false;
        $flagTradersSqlFile = false;

        $return = [];

        $return['lines'] = file('test/clients.txt');
        $return['count'] = count($return['lines']);
        $return['clientsIds'] = implode(",", array_values($return['lines']));
        // $users = Yii::app()->db->createCommand("SELECT count(DISTINCT id) as total from leads_and_clients where id in ( $)")->queryAll();

        if($flagTradersFile) {
            $traders = Yii::app()->db->
            createCommand("
                SELECT 
                #lac.user_id, 
                u.email
                FROM leads_and_clients lac
                RIGHT JOIN users u ON u.id = lac.user_id
                WHERE lac.id IN ($return[clientsIds])
            ")->queryAll();

            $fp = fopen('test/traders.txt', "w");
            foreach ($traders as $traderData) {
                fwrite($fp, $traderData['email'] . "\r\n");
            }
            fclose($fp);
        }

        if($flagAccountsFile) {
            $traders = Yii::app()->db->
            createCommand("
                SELECT 
                a.server_account
                FROM leads_and_clients lac
                RIGHT JOIN accounts a ON a.user_id = lac.user_id
                WHERE lac.id IN ($return[clientsIds])
            ")->queryAll();

            $fp = fopen('test/accounts.txt', "w");
            foreach ($traders as $traderData) {
                fwrite($fp, $traderData['server_account'] . "\r\n");
            }
            fclose($fp);
        }

        if($flagLeadsSqlFile) {
            $fp = fopen('test/2391_leads.txt', "w");

            fwrite($fp, "DELETE FROM leads_and_clients WHERE id IN (" . "\r\n");
            $n = $step = 2000;
            $i = 0;
            foreach ($return['lines'] as $line) {
                $i++;
                fwrite($fp, trim($line));
                if($i == $n) {
                    fwrite($fp, "\r\n" . ");" . "\r\n");
                    fwrite($fp, "DELETE FROM leads_and_clients WHERE id IN (" . "\r\n");
                    $n = $n + $step;
                } else {
                    if ($i != $return['count']){
                        fwrite($fp, ",");
                    }
                    fwrite($fp, "\r\n");
                }
            }
            fwrite($fp, ");" . "\r\n");

            fclose($fp);
        }

        if($flagTradersSqlFile) {
            $fp = fopen('test/2391_traders.sql', "w");

            fwrite($fp, "DELETE FROM users WHERE id IN (" . "\r\n");
            $n = $step = 2000;
            $i = 0;
            $traders = Yii::app()->db->
            createCommand("
                SELECT 
                u.id
                FROM leads_and_clients lac
                RIGHT JOIN users u ON u.id = lac.user_id
                WHERE lac.id IN ($return[clientsIds])
            ")->queryAll();

            var_dump($traders);

            foreach ($traders as $line) {
                $i++;
                fwrite($fp, trim($line['id']));
                if($i == $n) {
                    fwrite($fp, "\r\n" . ");" . "\r\n");
                    fwrite($fp, "DELETE FROM users WHERE id IN (" . "\r\n");
                    $n = $n + $step;
                } else {
                    if ($i != $return['count']){
                        fwrite($fp, ",");
                    }
                    fwrite($fp, "\r\n");
                }
            }
            fwrite($fp, ");" . "\r\n");

            fclose($fp);
        }

//        file_put_contents('test/traders.txt', json_encode(array_values($traders)));
    }
	
}

/*

        if($flagLeadsSqlFile || true) {
//            $fp = fopen('test/2391_leads.txt', "w");

            echo "DELETE FROM leads_and_clients WHERE id IN (" . "<br>";
            $n = $step = 7;
            $i = 0;
            foreach ($return['lines'] as $line) {
                $i++;
                echo trim($line);
                if($i == $n) {
                    echo  "<br>" . ");" . "<br>";
                    echo "DELETE FROM leads_and_clients WHERE id IN (" . "<br>";
                    $n = $n + $step;
                } else {
                    if ($i != $return['count']){
                        echo ",";
                    }
                    echo "<br>";
                }
            }
            echo ");" . "<br>";
//            fclose($fp);
        }
		*/


?>
