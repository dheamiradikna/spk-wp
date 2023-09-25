<?php
/* *
 * -----------------------------------------
 * | Dummy Data Insert Into Session Server |
 * -----------------------------------------
 * Criteria :
 * C1 : Kesesuaian proposal yang diajukan terhadap persyaratan PNPM
 * C2 : Kegiatan yang diajukan mendesak untuk dilakukan
 * C3 : Pendapatan per tahun masyarakat (Rp)
 * C4 : Lokasi desa dilihat dari jarak dengan pusat pemerintahan (km)
 * C5 : Tingkat kemajuan desa
 * -----------------------------------------
 */
session_start();

$_SESSION['data_alternatif'] = array(
	array(
		"NamaDaerah" => "Sumber",
		"C1" 		 => 5,
		"C2" 		 => 5,
		"C3" 		 => 1000000,
		"C4" 		 => 20,
		"C5" 		 => 5
	),

	array(
		"NamaDaerah" => "Sariharjo",
		"C1" 		 => 5,
		"C2" 		 => 5,
		"C3" 		 => 800000,
		"C4" 		 => 22,
		"C5" 		 => 5
	),

	array(
		"NamaDaerah" => "Sinduharjo",
		"C1" 		 => 5,
		"C2" 		 => 3,
		"C3" 		 => 850000,
		"C4" 		 => 25,
		"C5" 		 => 5
	),

	array(
		"NamaDaerah" => "Windusari",
		"C1" 		 => 3,
		"C2" 		 => 5,
		"C3" 		 => 900000,
		"C4" 		 => 23,
		"C5" 		 => 5
	),

	array(
		"NamaDaerah" => "Mranggen",
		"C1" 		 => 5,
		"C2" 		 => 3,
		"C3" 		 => 1050000,
		"C4" 		 => 24,
		"C5" 		 => 5
	),

);

$uri = "http://localhost/spk-wp/";
$http_response_code = 302;
header("Location: ".$uri, TRUE, $http_response_code);
exit();