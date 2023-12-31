<?php
session_start();
include "../config/library_config.php";
include "metode_wp.php";
include "CUD_data.php";
$act = isset($_GET['act']) ? $_GET['act'] : "";

switch($act){
	case "create" :
		if(isset($_POST)){
			$data = array (
				0 => $_POST['NamaDaerah'],
				1 => $_POST['Proposal'],
				2 => $_POST['Kegiatan'],
				3 => $_POST['Pendapatan'],
				4 => $_POST['LokasiDesa'],
				5 => $_POST['TingkatKemajuan'],
			);

			create($data);
		}
	break;

	case "update" :
		if(isset($_POST)){
			$id = $_POST['ID'];
			$data = array (
				0 => $_POST['NamaDaerah'],
				1 => $_POST['Proposal'],
				2 => $_POST['Kegiatan'],
				3 => $_POST['Pendapatan'],
				4 => $_POST['LokasiDesa'],
				5 => $_POST['TingkatKemajuan']
			);

			update($id, $data);
		}
	break;

	case "delete" :
		if(isset($_GET['id'])){
			$id = $_GET['id'];

			delete($id);
		}
	break;

	case "cleardata" :
		if(isset($_GET['sure'])){
			unset($_SESSION);
			session_destroy();
		}
	break;

	case "proses_spk" :
		if(isset($_GET['sure'])){
			$w 		= $_SESSION['weight_criteria'];
			$w_k	= $_SESSION['weight_rule'];
			$data 	= $_SESSION['data_alternatif'];
			
			$_SESSION['hasil_keputusan']['row'] = metode_wp($w, $w_k, $data);
		}
	break;
}

redirect(base_url());
?>