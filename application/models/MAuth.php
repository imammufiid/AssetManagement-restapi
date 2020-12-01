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
         return ['status' => false,  'message' => 'Request Null'];
      } else {
         $query = $this->db
            ->select('u.id, u.username, u.email, u.status, u.password, k.key')
            ->from('t_users u')
            ->from('t_keys k', 'k.user_id = u.id')
            ->where('username', $username)
            ->get()
            ->row();

         if (!empty($query)) {
            if (password_verify($password, $query->password)) {
               return [
                  'status' => true,
                  'data' => $query
               ];
            } else {
               return ['status' => false, 'message' => 'Password Wrong!'];
            }
         } else {
            return ['status' => false, 'message' => 'User Not Found!'];
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

      // create users

      if (!$this->db->insert('t_users', $newData)) {
         return false;
      }

      // generate key
      $dataGenerate = [
         'user_id' => $this->db->insert_id(),
         'key' => password_hash($newData['email'], PASSWORD_BCRYPT),
         'level' => 1,
         'ignore_limits' => 1,
         'date_created' => date('Y-m-d H:i:s')
      ];

      if ($this->db->insert('t_keys', $dataGenerate)) {
         return true;
      } else {
         return false;
      }
   }
}
