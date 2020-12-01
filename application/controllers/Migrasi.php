<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migrasi extends CI_Controller
{

	public function index()
	{
		$path = FCPATH . "database";
		$sql = file($path . "\assets.sql");

		// Loop through each line
		$templine = '';
		foreach ($sql as $line) {
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;

			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';') {
				// Perform the query
				$this->db->query($templine) or print('Error performing query \'<strong>' . $templine . '\':'. $this->db->error() .' <br /><br />');
				// Reset temp variable to empty
				$templine = '';
			}
		}
	}
}
