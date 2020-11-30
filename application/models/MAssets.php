<?php
defined('BASEPATH') or exit('No direct script access allowed');

const GET = 1;
const GETBYID = 2;
const INSERT = 3;
const UPDATE = 4;
const DELETE = 5;

class MAssets extends CI_Model
{

	public function get($id = 0)
	{
		if ($id = 0) {
			return $this->db->get('t_assets')->result();
		} else {
			return $this->db->get_where('t_assets', ['id' => $id])->row();
		}
	}

	public function action($id = 0, $action = 0, $data = null)
	{
		if ($id != 0) {
			switch ($action) {
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
}
