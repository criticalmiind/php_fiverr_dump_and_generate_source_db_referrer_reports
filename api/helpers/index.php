<?php

    /**
     *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
     *  origin.
     *
     *  In a production environment, you probably want to be more restrictive, but this gives you
     *  the general idea of what is involved.  For the nitty-gritty low-down, read:
     *
     *  - https://developer.mozilla.org/en/HTTP_access_control
     *  - https://fetch.spec.whatwg.org/#http-cors-protocol
     *
     */
    function cors() {
        
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
        // echo "You have CORS!";
    }

	function response($data, $msg, $success, $res='api', $status=200) {
        if($res === 'api'){
            if($success){
                http_response_code($status);
                return json_encode([ "data"=>$data, "message"=>$msg, "success"=>$success ]);
            }else {
                http_response_code($status);
                return json_encode([ "data"=>$data, "message"=>$msg, "success"=>$success ]);
            }
        }else{
            return array( "data"=>$data, "message"=>$msg, "is"=>$success?1:0 );
        }
	}

	// Function to remove the spacial
	function RemoveSpecialChar($str) {
	    $res = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $str);
	    return $res;
    }

    function generateRandomString($length = 20, $isSpecialChar = true) {
        $string = $isSpecialChar ? '-_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($x=$string, ceil($length/strlen($x)) )),1,$length);
    }