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
		if ($id != null) {
			switch ($action) {
				case 2:
					$this->get($id);
					break;
				case 4:
					$this->db->update('t_assets', $data, ['id' => $id]);
					return $this->db->affected_rows();
					break;
				case 5:
					$this->db->delete('t_assets', ['id' => $id]);
					return $this->db->affected_rows();
					break;
				default:
					return 0;
					break;
			}
		} else {
			switch ($action) {
				case 3:
					$this->db->insert('t_assets', $data);
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
		if($id === null) {
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
