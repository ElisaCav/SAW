<?php  
 //require_once '../php/auth.php';
 //denyUnauthenticatedAccess($con);
 ini_set('log_errors', 0);
ini_set('display_errors', 0);
error_reporting(0); // or set to 0 for production

ini_set('log_errors', 0);	


//ini_set('error_log', '../logs/dbconnections.log');

    function escape_string($data) {
    if (is_string($data)) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
    }

    function fetch_single_result($con,$query,$params_types,$params){					
        $stmt=mysqli_stmt_init($con);
        execute_prepared_statement($stmt,$query,$result,$params_types,$params);
        if(!$result){
            error_log("get_result", mysqli_error($con));
            exit("get_result failed");
        }

        $data = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
	    mysqli_stmt_close($stmt);

        if($data!==null){
            return array_map('escape_string', $data);
        }else{
            return $data;
        }
    }

    function fetch_multiple_results( $con, $query,$params_types,$params){
        $stmt=mysqli_stmt_init($con);
        execute_prepared_statement($stmt,$query,$result,$params_types,$params);
        $rowcount=mysqli_num_rows($result);
        if ($rowcount<1) {
            error_log("Data not found\n");
        }
        $data=array();
        while($row=mysqli_fetch_assoc($result)){
             $data[] = array_map('escape_string', $row);
        }
        mysqli_free_result($result);
	    mysqli_stmt_close($stmt);
        return $data;
    }

    function update_table($con,$query,$params_types,$params){   
        $stmt=mysqli_stmt_init($con);
        execute_prepared_statement($stmt,$query,$result,$params_types,$params);
        $affected_rows=mysqli_affected_rows($con);
        if($affected_rows<=0) {
            error_log("No data updated");
        }
	    mysqli_stmt_close($stmt);  
        return $affected_rows; 
    }  

    function execute_prepared_statement($stmt, $query, &$result, $param_types, $params)
    {
        if(!mysqli_stmt_prepare($stmt,$query)){
            error_log("prepare failed", mysqli_stmt_errno($stmt));
            exit("update query: prepare failed");
        }
       #bind_param is used for binding the ? with variabless
       # ...$params used because $params is array
        
        if(!is_array($params)) $params = array($params);
        if(!mysqli_stmt_bind_param($stmt,$param_types,...$params)){
            error_log("bind failed", mysqli_stmt_errno($stmt));
            exit("update query: error in bind");
        }
        
        if(!mysqli_stmt_execute($stmt)){
           error_log("execute failed", mysqli_stmt_errno($stmt));
           exit("update query: error in execute");
       }
       $result= mysqli_stmt_get_result($stmt);
    }

    
    function fetch_values_no_params($con,$query){
        error_log("prepare");
        if(!$stmt=mysqli_prepare($con,$query)){
             error_log("prepare failed", mysqli_error($con));
             exit("prepare failed");
         }
        #execute the query
        if(!mysqli_stmt_execute($stmt)){
            error_log("execute failed", mysqli_error($con));
            exit("execute failed");
        }
        if(!$stmt_result=mysqli_stmt_get_result($stmt)){
            error_log("get_result failed", mysqli_error($con));
            exit("get_result failed");
        }
        $num_rows = mysqli_num_rows($stmt_result);
        if ($num_rows<1) {
            echo "Data not found\n";
        }
        $data=array();
        while($row=mysqli_fetch_assoc($stmt_result)){
            $data[] = array_map('escape_string', $row);
        }
        mysqli_free_result($stmt_result);
        mysqli_stmt_close($stmt);
        return $data; 
    }

?>