<?php

namespace PHPMaker2022\pubinamarga;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions
// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
    if ($_SERVER['SERVER_NAME'] != "localhost") {
		$info["host"] = "localhost";
		$info["user"] = "root";
		$info["pass"] = "";
		$info["port"] = "3306";
		$info["db"] = "disdukcapil-chatbot";
	}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

$print = "";

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });

    $app->get('/downloadPertanyaan', function ($request, $response, $args) {
	$data = ExecuteRows('SELECT * FROM pertanyaan');

	$print = "<center><h3>Data List Pertanyaan</h3></center><hr/><br/>";

	$print .= "<ul>";
        foreach ($data as $row) {
                $nama = $row['nama'];
                $code = $row['code'];
                $jawaban = $row['jawaban'];
                if ($jawaban) {
			$print .= "<li><b>$nama-$code</b>, <br> <b>Jawaban</b> : $jawaban";
		}else{
			$print .= "<li><b>$nama-$code</b>";
		}

                $print .= "</li>";
        }
        $print .= "</ul>";

	$dompdf = new \Dompdf\Dompdf();    
        $dompdf->loadHtml($print);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream('List Pertanyaan.pdf');
    });
}

// API Action event
function Api_Action($app)
{    
   $app->get('/getQrCode', function ($request, $response, $args) {
        $dataQr = ExecuteRow('SELECT * FROM setting WHERE `key` = "qr_code"');
        $dataStatusApp = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_app"');
        $dataStatus = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_connection_app"');
        return $response->withJson(["Qr" => $dataQr, 'status_app' => $dataStatusApp, 'status' => $dataStatus]);
    });
    $app->get('/getQrCode2', function ($request, $response, $args) {
        $dataQr = ExecuteRow('SELECT * FROM setting WHERE `key` = "qr_listchatbot_code"');
        $dataStatusApp = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_app"');
        $dataStatus = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_connection_lustchatbot_app"');
        return $response->withJson(["Qr" => $dataQr, 'status_app' => $dataStatusApp, 'status' => $dataStatus]);
    });
    $app->get('/getPolygon', function ($request, $response, $args) {
        $jalan_id = $request->getQueryParam('jalan_id');
        $polygon = ExecuteRows("SELECT * FROM kordinat_jalan WHERE `jalan_id` = $jalan_id");
        $polygonArr = [];
        foreach($polygon as $row){
            array_push($polygonArr, ["lat" => floatval($row['lat']), "lng" => floatval($row['long'])]);
        }
        return $response->withJson(["polygon" => json_encode($polygonArr)]);
    });
    $app->post('/saveLocation', function ($request, $response, $args) {
        $jalan_id = $request->getParsedBodyParam('jalan_id');
        $polygon = $request->getParsedBodyParam('polygon');
        $polygon = explode(",(",$polygon);
        ExecuteUpdate("DELETE FROM kordinat_jalan WHERE jalan_id = $jalan_id");
        foreach($polygon as &$row){
            $row = str_replace("(", "", $row);
            $row = str_replace(")", "", $row);
            $row = explode(",",$row);
            foreach($row as &$subrow){
                $subrow = str_replace(" ", "", $subrow);
            }
            $lat = $row[0];
            $long = $row[1];
            $row[2] = "INSERT INTO kordinat_jalan (`jalan_id`, `lat`, `long`) VALUES ($jalan_id, $lat, $long);";
            ExecuteUpdate($row[2]);
        }
        return $response->withJson(["data" => [$jalan_id, $polygon]]);
    });
    $app->get('/getUserListv1', function ($request, $response, $args) {
        $data = ExecuteRows("SELECT pelapor.*, COALESCE(pelapor.nama, pelapor.phone) as nama FROM pelapor JOIN log_user_chat as `luc` ON luc.pelapor_id = pelapor.id GROUP BY luc.pelapor_id");
        return $response->withJson(["data" => $data]);
    });

    $app->get('/getUserList', function ($request, $response, $args) {
        $tahun = date("Y");
        $bulan = date("m");
        $hari = date("d");

        $data = ExecuteRows("SELECT pelapor.*, COALESCE(pelapor.nama, pelapor.phone) as nama FROM pelapor JOIN log_user_chat as `luc` ON luc.pelapor_id = pelapor.id WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan' AND DAY(luc.tanggal) = '$hari' GROUP BY luc.pelapor_id");
        return $response->withJson(["data" => $data]);
    });

    $app->get('/getUserChatLog/{userId}', function ($request, $response, $args) {
        //$data = [];
        //if(isset($args['userId'])){
        //    $userId = $args['userId'];
        //    $data = ExecuteRows("SELECT * FROM log_user_chat as `luc` JOIN pelapor  ON luc.pelapor_id = pelapor.id WHERE pelapor.id = $userId ORDER BY luc.tanggal ASC");
        //}
        //return $response->withJson(["data" => $data]);
        $data = [];
        $tahun = date("Y");
        $bulan = date("m");
        $hari = date("d");
        if(isset($args['userId'])){
            $userId = $args['userId'];

            $limit = 100;
            $page = 0;

            $queryLimit = "LIMIT $limit OFFSET $page";

            $page = $request->getQueryParam('page');
            if(isset($page)){
                $page = ($page == 1 ? 0 : intval($page) * $limit);
                // print_r($page);
                $queryLimit = "LIMIT $limit OFFSET $page";
            }

            $data = ExecuteRows("SELECT *, CASE WHEN code = 'Sys' THEN 'LewatWa' ELSE code END as code FROM log_user_chat as `luc` JOIN pelapor  ON luc.pelapor_id = pelapor.id WHERE pelapor.id = $userId AND tanggal >= ( CURDATE() - INTERVAL 3 DAY ) ORDER BY luc.tanggal ASC $queryLimit");
             usort($data, function($a, $b) {
                $ad = new \DateTime($a['tanggal']);
                $bd = new \DateTime($b['tanggal']);
              
                if ($ad == $bd) {
                  return 0;
                }
              
                return $ad < $bd ? -1 : 1;
            });
        }
        return $response->withJson(["data" => $data]);
    });

    $app->get('/getAllUserChatCount', function ($request, $response, $args) {
        $data = [];
        $where = "";
        $tahun = date("Y");
        $bulan = date("m");
        $hari = date("d");
        
        $type = $request->getQueryParam('type');
        if(isset($type)){
            switch ($type) {
                case 'hariini':
                    $where = "WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan' AND DAY(luc.tanggal) = '$hari'";
                    break;
                
                case 'bulanini':
                    $where = "WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan'";
                    break;
                
                case 'tahunini':
                    $where = "WHERE YEAR(luc.tanggal) = '$tahun'";
                    break;
                
                default:
                    $where = "";
                    break;
            }            
        }
        
        $data = ExecuteRows("SELECT COUNT(*) as total_chat_user FROM log_user_chat as `luc` $where ORDER BY luc.tanggal ASC");

        return $response->withJson($data);
    });

       $app->get('/getUserChatLogAll', function ($request, $response, $args) {
        $tahun = date("Y");
        $bulan = date("m");
        $hari = date("d");

        $data = ExecuteRows("SELECT luc.*, pelapor.* FROM log_user_chat as `luc` JOIN pelapor ON luc.pelapor_id = pelapor.id WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan' AND DAY(luc.tanggal) = '$hari' ORDER BY luc.tanggal DESC");
        return $response->withJson($data);
    });

   $app->get('/getUserTotal', function ($request, $response, $args) {
    $data = [];
    $where = "";
    $tahun = $request->getQueryParam('tahun') ?? date("Y");
    $bulan = $request->getQueryParam('bulan') ?? date("m");
    $hari = date("d");

    $type = $request->getQueryParam('type');
    if(isset($type)){
        switch ($type) {
            case 'bulan':
                $where = "WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan'";
                break;

            case 'tahun':
                $where = "WHERE YEAR(luc.tanggal) = '$tahun'";
                break;

            default:
                $where = "";
                break;
        }
    }

    $data = ExecuteRows("SELECT MONTH(tanggal) AS `bulan`, COUNT(DISTINCT(pelapor_id)) as jml_pelapor FROM log_user_chat as `luc` JOIN pelapor ON pelapor.id = `luc`.pelapor_id $where GROUP BY 1 ORDER BY 1 ASC");

    return $response->withJson($data);
});

       $app->get('/getUserTotalChat', function ($request, $response, $args) {
        $data = [];
        $where = "";
        $tahun = date("Y");
        $bulan = date("m");
        $hari = date("d");
        
        $type = $request->getQueryParam('type');
        if(isset($type)){
            switch ($type) {
                case 'hariini':
                    $where = "WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan' AND DAY(luc.tanggal) = '$hari'";
                    break;
                
                case 'bulanini':
                    $where = "WHERE YEAR(luc.tanggal) = '$tahun' AND MONTH(luc.tanggal) = '$bulan'";
                    break;
                
                case 'tahunini':
                    $where = "WHERE YEAR(luc.tanggal) = '$tahun'";
                    break;
                
                default:
                    $where = "";
                    break;
            }            
        }
        
        $data = ExecuteRows("SELECT COALESCE(pelapor.nama, pelapor.phone) as user, COUNT(`luc`.id) as total_chat_user FROM log_user_chat as `luc` JOIN pelapor ON pelapor.id = `luc`.pelapor_id $where GROUP BY 1 ORDER BY 2 DESC");

        return $response->withJson($data);
    });
    
    $app->post('/sendMessage', function ($request, $response, $args) {        
        
        $message = $request->getParsedBodyParam('message');
        $userId = $request->getParsedBodyParam('userId');        
        $userName = $request->getParsedBodyParam('userName');
        $userData = ExecuteRow("SELECT * FROM pelapor WHERE id = $userId");

        if(!empty($userData)){
            // $pelaporId = $userData['id'];  
            // $pesan =   
            $tanggal = date("Y-m-d H:i:s");  
            // $code =                       
            
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL,"http://localhost:5000/chat/sendmessage/".$userData['phone']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "message=".$message);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $server_output = curl_exec($ch);

            if(json_decode($server_output, true)['status'] == 'success'){
                ExecuteUpdate("INSERT INTO log_user_chat (pelapor_id, pesan, tanggal, code) VALUES($userId, '$message', '$tanggal', '$userName')");
            } 
            
            curl_close ($ch); 
        }else{
            $server_output = json_encode(['status' => 'failed', 'message' => 'User Nor Found']);
        }

        return $response->withJson(json_decode($server_output, true));
    });

    $app->post('/updatePelapor', function ($request, $response, $args) {
      $userId = $request->getParsedBodyParam('userId');
      $userName = $request->getParsedBodyParam('status');
      $userData = ExecuteUpdate("UPDATE pelapor SET status = '$userName' WHERE phone = '$userId'");

      return $response->withJson(['message' => 'Success']);
    });
    $app->get('/getUserLogList', function ($request, $response, $args) {
    $startDate = $request->getQueryParam('startDate');
    $endDate = $request->getQueryParam('endDate');
    
    $whereQuery = "";
    if(!empty($startDate) && !empty($endDate)){
        $startDate = $startDate." 00:00:00";
        $endDate = $endDate." 23:59:59";
        $whereQuery = "WHERE luc.tanggal BETWEEN '$startDate' AND '$endDate'";
    }

    $data = ExecuteRows("SELECT pelapor.id, pelapor.nama,pelapor.nik,pelapor.phone, luc.tanggal as waktu, luc.pesan FROM log_user_chat as `luc` JOIN pelapor ON luc.pelapor_id = pelapor.id $whereQuery ORDER BY luc.tanggal DESC");

    return $response->withJson($data);
});

 $app->post('/updatePelaporHandle', function ($request, $response, $args) {
      $userId = $request->getParsedBodyParam('userId');
      $userName = $request->getParsedBodyParam('status');
      $userData = ExecuteUpdate("UPDATE pelapor SET handle_status = '$userName' WHERE phone = '$userId'");

      return $response->withJson(['message' => 'Success']);
    });

}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

        function print_list($array, $parent = null, $print = "") {
            $print .= "<ul>";
            foreach ($array as $row) {
                $nama = $row['nama'];
                $code = $row['code'];
                $jawaban = $row['jawaban'];
                if ($row['pid'] == $parent) {
                    if ($row['jawaban']) {
			$print .= "<li><b>$nama-$code</b>, <br> <b>Jawaban</b> : $jawaban";
		    } else {
		   	$print .= "<li><b>$nama-$code</b>";
  		    }

                    print_list($array, $row['id'], $print);

                    $print .= "</li>";
                }   
            }
            $print .= "</ul>";

	   return $print;
        }

	function print_listAs($array) {
		$var = "";

		$var = print_list($array, null, $var);

		return $var;
	}
