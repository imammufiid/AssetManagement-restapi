<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MAuth extends CI_Model
{

   /**
    * login function
    *
    * @param stirng $username
    * @param string $password
    * @return void response
    */
   public function getByLogin($username = null, $password = null)
   {
      if ($username == null || $password == null) {
         return 0;
      } else {
         $query = $this->db
            ->get_where('t_users', ['username' => $username])
            ->row();


         if (!empty($query)) {
            if (password_verify($password, $query->password)) {
               return [
                  'status' => true,
                  'data' => $query
               ];
            } else {
               return ['status' => false];
            }
         }
      }
   }

   /**
    * registration function
    *
    * @param array $data
    * @return void response
    */
   public function registration($data = [])
   {
      $password = trim($data['password']);

      $newData = [
         'username' => trim($data['username']),
         'email' => trim($data['email']),
         'password' => password_hash($password, PASSWORD_DEFAULT),
      ];

      if ($this->db->insert('t_users', $newData)) {
         return true;
      } else {
         return false;
      }
   }
}
