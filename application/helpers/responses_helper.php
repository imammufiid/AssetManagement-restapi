<?php

use const chriskacerguis\RestServer\HTTP_UNAUTHORIZED;

/**
 * custom get response API
 *
 * @param [HTTP_CODE] $status http code status
 * @param string $message
 * @param Array $data
 * @return void response
 */
function myResponse($status = HTTP_UNAUTHORIZED, $message = "", $data = null) {
   $ci =& get_instance();
   if($data == null) {
      $ci->response([
         'status' => $status,
         'message' => $message,
      ], $status);
      
   } else {
      $ci->response([
         'status' => $status,
         'message' => $message,
         'data' => $data
      ], $status);

   }
}