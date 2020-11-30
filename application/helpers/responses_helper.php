<?php

use const chriskacerguis\RestServer\HTTP_UNAUTHORIZED;

function successResponse($status = HTTP_UNAUTHORIZED, $message = "", $data = null) {
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