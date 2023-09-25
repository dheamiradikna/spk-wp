<?php
//Fetch data alternatif from session
function fetch_data(){
	//check is there any data ? then fetch
	if(isset($_SESSION['data_alternatif'])){
		$datas = $_SESSION['data_alternatif'];
	}

	//check is there a decission result ?
	$row_result = isset($_SESSION['hasil_keputusan']['row']) ? $_SESSION['hasil_keputusan']['row'] : "";

	//echo table
	echo "
		<div class='row'>
		<div class='col-sm-12 col-md-12 data-table'>
		<div class='panel panel-default'>
			<div class='panel-heading'>Data Alternatif</div>
			<div class='panel-body'>
			<table class='table table-condensed table-hover table-bordered'>
				<tr>
					<th>No</th>
					<th>Nama Daerah</th>
					<th>Kesesuaian Proposal</th>
					<th>Kegiatan yang Mendesak</th>
					<th>Pendapatan/Tahun (Rp)</th>
					<th>Lokasi Desa dari Jarak Pemerintah Pusat (km)</th>
					<th>Tingkat Kemajuan Desa</th>
					<th colspan='2'>Action</th>
				</tr>
	";
	//echo data, if exist
	if(isset($_SESSION['data_alternatif'])){
		$k=0;
		foreach ($datas as $data) {
			$Proposal = "";
			foreach($_SESSION['rc']['Proposal'] as $md => $nilai){
				if($data['C1'] == $nilai){
					$Proposal = $md;
					break;
				}
			}

			$TingkatKemajuan = "";
			foreach($_SESSION['rc']['TingkatKemajuan'] as $aman => $nilai){
				if($data['C5'] == $nilai){
					$TingkatKemajuan = $aman;
					break;
				}
			}

			$update = 	"
				<a href='".base_url("index.php?act=update&act=update&id=".$k)."'>
					<span class='glyphicon glyphicon-edit'></span>
					<span class='sr-only'>Update</span>
				</a>
			";
			
			$delete = 	"
				<a href='".base_url("page/aksi_proses_spk.php?act=delete&id=".$k)."' onclick='return confirm(\"Hapus Data ?\");'>
					<span class='glyphicon glyphicon-trash'></span>
					<span class='sr-only'>Delete</span>
				</a>
			";

			$tag_open = ($row_result === $k) ? "<tr class='success'>" : "<tr>";
			echo "
					".$tag_open."
						<td>".++$k."</td>
						<td>".$data['NamaDaerah']."</td>
						<td>".$Proposal."</td>
						<td>".$data['C2']."</td>
						<td>".$data['C3']."</td>
						<td>".$data['C4']."</td>
						<td>".$TingkatKemajuan."</td>
						<td>".$update."</td>
						<td>".$delete."</td>
					</tr>
			";
		}
	}
	//echo close tag
	echo "
			</table>
			</div>
		</div>
		</div>
		</div>
	";
}

//Create data alternatif
function tambah_data_alternatif(){
	echo "
		<form action='".base_url('page/aksi_proses_spk.php?act=create')."' method='POST'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Tambah Data Alternatif</div>
				<div class='panel-body'>
				<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='NamaDaerah'>Nama Daerah</label>
						<input type='text' class='form-control input-sm' name='NamaDaerah' id='NamaDaerah' placeholder='Nama Daerah' value='' />
					</div>

			<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='Proposal'>1. Kesesuaian Proposal</label>
						<select class='form-control input-sm' name='Proposal' id='Proposal'>
	";
	foreach($_SESSION['rc']['Proposal'] as $md => $nilai){
		echo "
			<option value='".$nilai."'>".$md."</option>
		";
	}
	echo "
						</select>
					</div>
				
				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='Kegiatan'>2. Kegiatan yang Mendesak</label>
						<div class='input-group'>
							<input type='text' class='form-control input-sm' name='Kegiatan' id='Kegiatan' placeholder='Kegiatan yang Diajukan Mendesak untuk Dilakukan' value='' />
							<span class='input-group-addon'></span>
						</div>
					</div>

				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='Pendapatan'>3. Pendapata/tahun</label>
						<div class='input-group'>
							<input type='text' class='form-control input-sm' name='Pendapatan' id='Pendapatan' placeholder='Pendapatan/tahun Masyarakat' value='' />
							<span class='input-group-addon'>Rp</span>
						</div>
					</div>
				
				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='LokasiDesa'>4. Lokasi dari Pemerintah Pusat (km)</label>
						<div class='input-group'>
							<input type='text' class='form-control input-sm' name='LokasiDesa' id='LokasiDesa' placeholder='Lokasi Desa dari Jarak Pemerintah Pusat' value='' />
							<span class='input-group-addon'>km</span>
						</div>
					</div>

				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='TingkatKemajuan'>5. Tingkat Kemajuan Desa</label>
						<select class='form-control input-sm' name='TingkatKemajuan' id='TingkatKemajuan'>
	";
	foreach($_SESSION['rc']['TingkatKemajuan'] as $aman => $nilai){
		echo "
			<option value='".$nilai."'>".$aman."</option>
		";
	}
	echo "
						</select>
					</div>

				<!--
					========================================================
				-->		

					<div class='form-group'>
						<input type='submit' name='CreateAlternatif' value='Submit' class='btn btn-primary' />
						<input type='reset' name='Reset' value='Reset' class='btn btn-default' />
					</div>
				</div>
			</div>
		</form>
	";
}

//Update data alternatif
function update_data_alternatif(){
	//is there data table and id for update ?
	if(!isset($_SESSION['data_alternatif']) && !isset($_GET['id'])){
		redirect(base_url());
	}

	//is there offset array ?
	$row  = $_GET['id'];
	$last = end(array_keys($_SESSION['data_alternatif']));
	if(!($row >= 0 && $row <= $last)){
		redirect(base_url());
	}

	//fetch data	
	$data = array(
		"ND" => $_SESSION['data_alternatif'][$row]['NamaDaerah'],
		"C1" => $_SESSION['data_alternatif'][$row]['C1'],
		"C2" => $_SESSION['data_alternatif'][$row]['C2'],
		"C3" => $_SESSION['data_alternatif'][$row]['C3'],
		"C4" => $_SESSION['data_alternatif'][$row]['C4'],
		"C5" => $_SESSION['data_alternatif'][$row]['C5']
	);
	
	//store fetch data to form
	echo "
		<form action='".base_url('page/aksi_proses_spk.php?act=update')."' method='POST'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Update Data Alternatif</div>
				<div class='panel-body'>
				<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='ID'>ID Row</label>
						<input type='text' class='form-control input-sm' name='ID' id='ID' placeholder='ID' value='".$row."' readonly='readonly' />
					</div>

				<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='NamaDaerah'>Nama Daerah</label>
						<input type='text' class='form-control input-sm' name='NamaDaerah' id='NamaDaerah' placeholder='Nama Daerah' value='".$data['ND']."' />
					</div>

				<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='Proposal'>1. Kesesuaian Proposal</label>
						<select class='form-control input-sm' name='Proposal' id='Proposal'>
						<span class='input-group-addon'></span>
	";
	foreach($_SESSION['rc']['Proposal'] as $md => $nilai){
		if($data['C1'] == $nilai){
			echo "
				<option value='".$nilai."' selected='selected'>".$md."</option>
			";
		} else {
			echo "
				<option value='".$nilai."'>".$md."</option>
			";
		}
	}
	echo "
						</select>
					</div>
				
				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='Kegiatan'>2. Kegiatan Mendesak</label>
						<div class='input-group'>
							<input type='text' class='form-control input-sm' name='Kegiatan' id='Kegiatan' placeholder='Kegiatan yang Diajukan' value='".$data['C2']."' />
							<span class='input-group-addon'></span>
						</div>
					</div>

				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='Pendapatan'>3. Pendapatan per tahun</label>
						<div class='input-group'>
						<input type='text' class='form-control input-sm' name='Pendapatan' id='Pendapatan' placeholder='Pendapatan per tahun' value='".$data['C3']."' />
						<span class='input-group-addon'>Rp</span>
						</div>
					</div>
				
				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='LokasiDesa'>4. Lokasi dari Pemerintah Pusat</label>
						<div class='input-group'>
							<input type='text' class='form-control input-sm' name='LokasiDesa' id='LokasiDesa' placeholder='Jarak dengan Gudang' value='".$data['C4']."' />
							<span class='input-group-addon'>km</span>
						</div>
					</div>

				<!--
					========================================================
				-->		
					<div class='form-group'>
						<label for='TingkatKemajuan'>5. Tingkat Kemajuan Desa</label>
						<select class='form-control input-sm' name='TingkatKemajuan' id='TingkatKemajuan'>
	";
	foreach($_SESSION['rc']['TingkatKemajuan'] as $aman => $nilai){
		if($data['C5'] == $nilai){
			echo "
				<option value='".$nilai."' selected='selected'>".$aman."</option>
			";
		} else {
			echo "
				<option value='".$nilai."'>".$aman."</option>
			";
		}
	}
	echo "
						</select>
					</div>

				<!--
					========================================================
				-->		

					<div class='form-group'>
						<input type='submit' name='UpdateAlternatif' value='Submit' class='btn btn-primary' />
						<input type='reset' name='Reset' value='Reset' class='btn btn-default' />
						<a href='".base_url()."' class='btn btn-default'>Kembali</a>
					</div>
				</div>
			</div>
		</form>
	";
}

//Control data alternatif form
function form_control_data(){
	$act = isset($_GET['act']) ? $_GET['act'] : "";

	if($act == "update"){
		update_data_alternatif();
	} else {
		tambah_data_alternatif();
	}
}

//Result Decission
function hasil_keputusan(){
	if(isset($_SESSION['hasil_keputusan']) && isset($_SESSION['data_alternatif'])){
		$row 		= $_SESSION['hasil_keputusan']['row']+1;
		$namadaerah = $_SESSION['data_alternatif'][$row-1]['NamaDaerah'];
	} else {
		$row 		= "";
		$namadaerah = ""; 
	}

	echo "
		<form>
			<div class='panel panel-default'>
				<div class='panel-heading'>Hasil Keputusan</div>
				<div class='panel-body'>
				<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='KRow'>Alternatif Nomor</label>
						<input type='text' class='form-control' name='KRow' id='KRow' value='".$row."' readonly='readonly' />
					</div>

				<!--
					========================================================
				-->	
					<div class='form-group'>
						<label for='KNamaDaerah'>Nama Daerah</label>
						<input type='text' class='form-control' name='KNamaDaerah' id='KNamaDaerah' value='".$namadaerah."' readonly='readonly' />
					</div>
				</div>
			</div>
		</form>
	";
}

//Button Decission proses and clear data
function panel_button_process(){
	echo "
		<form>
		<div class='panel panel-default'>
			<div class='panel-heading'>Tombol Proses</div>
			<div class='panel-body'>
				<div class='form-group'>
					<a href='".base_url('page/aksi_proses_spk.php?act=cleardata&sure=1')."' class='btn btn-danger btn-block'>Hapus Semua Data</a>
				</div>

				<div class='form-group'>
					<a href='".base_url('page/aksi_proses_spk.php?act=proses_spk&sure=1')."' class='btn btn-primary btn-block'>Hasilkan Keputusan</a>
				</div>
			</div>
		</div>
		</form>
	";
}

//Criteria Weight Information
function informasi_bobot_criteria(){
	$criterias = array(
		"Kesesuaian Proposal :"					=> $_SESSION['weight_criteria']['C1'],
		"Kegiatan yang  Mendesak :" 			=> $_SESSION['weight_criteria']['C2'],
		"Pendapatan/Tahun :" 					=> $_SESSION['weight_criteria']['C3'],
		"Lokasi dari Pemerintah Pusat :" 		=> $_SESSION['weight_criteria']['C4'],
		"Tingkat Kemajuan Desa :" 				=> $_SESSION['weight_criteria']['C5']
	);

	echo "
		<div class='panel panel-default'>
			<div class='panel-heading'>Informasi Bobot Kriteria</div>
			<div class='panel-body'>
				<ol>
	";
	foreach($criterias as $criteria => $bobot){
		echo "
					<li>".$criteria." ".$bobot."</li>
		";
	}
	echo "
				</ol>
			</div>
		</div>
	";
}
?>

<div class='row'>
	<div class='col-sm-4 col-md-4'><?php form_control_data(); ?></div>
	<div class='col-sm-3 col-md-3'><?php hasil_keputusan(); ?></div>
	<div class='col-sm-2 col-md-2'><?php panel_button_process(); ?></div>
	<div class='col-sm-3 col-md-3'><?php informasi_bobot_criteria(); ?></div>
</div>

<div class='row'>
	<div class='col-sm-12 col-md-12 data-table'><?php fetch_data(); ?></div>
</div>