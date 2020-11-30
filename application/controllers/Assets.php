<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

use const chriskacerguis\RestServer\HTTP_BAD_REQUEST;
use const chriskacerguis\RestServer\HTTP_CREATED;

class Assets extends RestController
{

   public function __construct()
   {
      parent::__construct();
      header('Content-Type: application/json');
      $this->load->model('MAssets', 'asset');
   }

   public function index_get()
   {
      $id = trim($this->get('id'));
      if(!empty($id)) {
         $getData = $this->asset->get();
      } else {
         $getData = $this->asset->get($id);
      }
      successResponse(HTTP_BAD_REQUEST, "This data", $getData);

   }

   public function index_post()
   {
      $data = [
         'user_id' => $this->post('user_id', true),
         'plat_mobil' => $this->post('plat_mobil', true),
         'no_rangka' => $this->post('no_rangka', true),
         'no_mesin' => $this->post('no_mesin', true),
         'owner_name' => $this->post('owner_name', true),
         'date_oil' => $this->post('date_oil', true)
      ];

      if($this->asset->action(0, INSERT, $data) == 1) {
         successResponse(HTTP_CREATED, "Success add data");
      } else {
         successResponse(HTTP_CREATED, "Failed add data");

      }
   }
   public function index_put()
   {
      $id = $this->put('id', true);
      $data = [
         'user_id' => $this->put('user_id', true),
         'plat_mobil' => $this->put('plat_mobil', true),
         'no_rangka' => $this->put('no_rangka', true),
         'no_mesin' => $this->put('no_mesin', true),
         'owner_name' => $this->put('owner_name', true),
         'date_oil' => $this->put('date_oil', true)
      ];

      if($this->asset->action($id, UPDATE, $data) == 1) {
         successResponse(HTTP_CREATED, "Success update data");
      } else {
         successResponse(HTTP_CREATED, "Failed update data");

      }
   }
   public function index_delete()
   {
      $id = $this->delete('id', true);
      if($this->asset->action($id, DELETE, null) == 1) {
         successResponse(HTTP_CREATED, "Success delete data");
      } else {
         successResponse(HTTP_CREATED, "Failed delete data");
      }
   }
}
