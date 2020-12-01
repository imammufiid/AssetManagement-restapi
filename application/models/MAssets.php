<?php

use phpDocumentor\Reflection\Types\Integer;

defined('BASEPATH') or exit('No direct script access allowed');

const GET = 1;
const GETBYID = 2;
const INSERT = 3;
const UPDATE = 4;
const DELETE = 5;

class MAssets extends CI_Model
{

	/**
	 * GET Data Asset
	 *
	 * @param integer $id assets
	 * @return array of data
	 */
	public function get($id = null)
	{
		if ($id == null) {
			return $this->db->get('t_assets')->result();
		} else {
			return $this->db->get_where('t_assets', ['id' => $id])->row();
		}
	}

	/**
	 * Action function for asset
	 *
	 * @param integer $id of asset
	 * @param integer $action GETBYID, INSERT, UPDATE, DELETE
	 * @param [type] $data POST or PUT
	 * @return void
	 */
	public function action($id = null, $action = null, $data = null)
	{
		$date = date("Y-m-d H:i:s");

		if ($data != null) {
			if($data['date_oil'] != null) {
				$date = $data['date_oil'];
			}
			$time = strtotime($date);
			$dateExpired = date("Y-m-d H:i:s", strtotime("+4 month", $time));
		}

		$newData = array_merge($data, [
			'date_oil' => $date,
			'date_expired_oil' => $dateExpired
		]);
		
		if ($id != null) {
			switch ($action) {
				case GETBYID:
					$this->get($id);
					break;
				case UPDATE:
					$this->db->update('t_assets', $newData, ['id' => $id]);
					return $this->db->affected_rows();
					break;
				case DELETE:
					$this->db->delete('t_assets', ['id' => $id]);
					return $this->db->affected_rows();
					break;
				default:
					return 0;
					break;
			}
		} else {
			switch ($action) {
				case INSERT:
					$this->db->insert('t_assets', $newData);
					return $this->db->affected_rows();
					break;

				default:
					return 0;
					break;
			}
			return 0;
		}
	}

	/**
	 * get data from database with limit
	 *
	 * @param integer $id
	 * @param integer $limit
	 * @param integer $offset
	 * @return void response
	 */
	public function getWithPaging($id = null, $limit = 10, $offset = 0)
	{
		if ($id === null) {
			return $this->db->get('t_assets', $limit, $offset)->result();
		} else {
			$this->get($id);
		}
	}

	/**
	 * Count of all data assets
	 *
	 * @return void 
	 */
	public function count()
	{
		return $this->db->get('t_assets')->num_rows();
	}
}
