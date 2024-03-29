<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use const chriskacerguis\RestServer\HTTP_BAD_REQUEST;
use const chriskacerguis\RestServer\HTTP_CREATED;
use const chriskacerguis\RestServer\HTTP_INTERNAL_ERROR;
use const chriskacerguis\RestServer\HTTP_NOT_FOUND;
use const chriskacerguis\RestServer\HTTP_OK;
use const chriskacerguis\RestServer\HTTP_UNAUTHORIZED;

const PERPAGE = 2;
class Assets extends RestController
{
   public function __construct()
   {
      parent::__construct();
      header('Content-Type: application/json');
      $this->load->model('MAssets', 'asset');
   }

   /**
    * GET data assets
    *
    * @return void response
    */
   public function index_get()
   {
      $id = $this->get('id', true);
      $userId = $this->get('user_id', true);
      
      try {
         if ($userId == null) {
            myResponse(HTTP_UNAUTHORIZED, "Unauthorized");
         } else {
            if ($id == null) {
               $getData = $this->asset->get($userId);
               myResponse(HTTP_OK, "This data", $getData);
            } else {
               $getData = $this->asset->get($userId, $id);
               if ($getData == null) {
                  myResponse(HTTP_OK, "Data not found");
               } else {
                  myResponse(HTTP_OK, "This data", $getData);
               }
            }
         }
      } catch (\Throwable $e) {
         myResponse(HTTP_INTERNAL_ERROR, "Internal Server Error");
      }
   }

   /**
    * GET data with Pagging
    *
    * @return void response
    */
   public function get_get()
   {
      $page = $this->get('page');
      $page = empty($page) ? 1 : $page;
      $totalData = $this->asset->count();
      $totalPage = ceil($totalData / PERPAGE);
      $start = ($page - 1) * PERPAGE;

      $listOfData = $this->asset->getWithPaging(null, PERPAGE, $start);

      if ($listOfData) {
         $data = [
            'status' => HTTP_OK,
            'message' => 'This data',
            'page' => $page,
            'total_data' => $totalData,
            'total_page' => $totalPage,
            'data' => $listOfData
         ];
         $this->response($data, HTTP_OK);
      } else {
         myResponse(HTTP_OK, "Data null");
      }
   }

   /**
    * INSERT data asset
    *
    * @return void response
    */
   public function index_post()
   {
      $data = [
         'user_id' => trim($this->post('user_id', true)),
         'merk_mobil' => trim($this->post('merk_mobil', true)),
         'plat_mobil' => trim($this->post('plat_mobil', true)),
         'no_rangka' => trim($this->post('no_rangka', true)),
         'no_mesin' => trim($this->post('no_mesin', true)),
         'owner_name' => trim($this->post('owner_name', true)),
         'date_oil' => trim($this->post('date_oil', true))
      ];

      if ($this->asset->action(null, INSERT, $data) == 1) {
         myResponse(HTTP_CREATED, "Success add data");
      } else {
         myResponse(HTTP_BAD_REQUEST, "Failed add data");
      }
   }

   /**
    * UPDATE data asset
    *
    * @return void response
    */
   public function index_put()
   {
      $id = $this->put('id', true);
      $data = [
         'user_id' => trim($this->put('user_id', true)),
         'merk_mobil' => trim($this->put('merk_mobil', true)),
         'plat_mobil' => trim($this->put('plat_mobil', true)),
         'no_rangka' => trim($this->put('no_rangka', true)),
         'no_mesin' => trim($this->put('no_mesin', true)),
         'owner_name' => trim($this->put('owner_name', true)),
         'date_oil' => trim($this->put('date_oil', true))
      ];

      if ($this->asset->action($id, UPDATE, $data) == 1) {
         myResponse(HTTP_CREATED, "Success update data");
      } else {
         myResponse(HTTP_CREATED, "Failed update data");
      }
   }

   /**
    * DELETE data asset
    *
    * @return void response
    */
   public function index_delete()
   {
      $id = $this->delete('id', true);
      if ($this->asset->action($id, DELETE, null) == 1) {
         myResponse(HTTP_CREATED, "Success delete data");
      } else {
         myResponse(HTTP_CREATED, "Failed delete data");
      }
   }

   public function search_get()
   {
      $query = trim($this->get('query', true));

      if(!empty($query)) {
         $result = $this->asset->search($query);
         if($result == null) {
            myResponse(HTTP_OK, "Data not Available", $result);
         } else {
            myResponse(HTTP_OK, "This data", $result);
         }
      } else {
         myResponse(HTTP_NOT_FOUND, "Data Not Found!");
      }

   }
}
