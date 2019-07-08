<?php
	/**
	 * 
	 */
	class M_barang extends CI_Model
	{
		
		function savebarang($nama_barang, $barang_stock_awal, $barang_stock_akhir, $barang_harga_modal, $barang_level,$jenis_barang, $barang_foto){
			$hsl = $this->db->query("INSERT INTO barang(barang_nama,barang_stock_awal,barang_stock_akhir,barang_harga_modal,barang_level,jenis_barang,barang_foto) VALUES ('$nama_barang','$barang_stock_awal','$barang_stock_akhir','$barang_harga_modal','$barang_level','$jenis_barang','$barang_foto')");
        	return $hsl;
		}

		function update_barangImage($barang_id,$nama_barang, $stock=0, $barang_harga_modal, $barang_foto, $diskon){
			$hsl = $this->db->query("UPDATE barang SET barang_nama='$nama_barang', barang_stock_awal=barang_stock_awal + '$stock',barang_stock_akhir=barang_stock_akhir + '$stock',barang_harga_modal='$barang_harga_modal',barang_foto='$barang_foto', diskon='$diskon' WHERE barang_id='$barang_id'");
     		return $hsl;
		}

		function update_barang_noImage($barang_id,$nama_barang, $stock=0, $barang_harga_modal, $diskon){
			$hsl = $this->db->query("UPDATE barang SET barang_nama='$nama_barang', barang_stock_awal=barang_stock_awal + '$stock',barang_stock_akhir=barang_stock_akhir + '$stock',barang_harga_modal='$barang_harga_modal', diskon='$diskon' WHERE barang_id='$barang_id'");
     		return $hsl;
		}

		function update_harga($br_id,$harga){
			$hsl = $this->db->query("UPDATE barang_reseller SET br_harga='$harga' WHERE br_id='$br_id'");
     		return $hsl;
		}

		function getIdbyName($nama_barang){
			$hasil=$this->db->query("SELECT * FROM barang WHERE barang_nama='$nama_barang' ORDER BY barang_id DESC LIMIT 1");
        	return $hasil;
		}

		function savebarangreseller($barang_id, $kuantitas, $harga){
			$hsl = $this->db->query("INSERT INTO barang_reseller(barang_id,br_kuantitas,br_harga) VALUES ('$barang_id', '$kuantitas', '$harga')");
        	return $hsl;
		}

		function savebarangnonreseller($barang_id, $harga){
			$hsl = $this->db->query("INSERT INTO barang_non_reseller(barang_id,bnr_harga) VALUES ('$barang_id', '$harga')");
        	return $hsl;
		}

		function update_barang_reseller($br_id, $harga){
			$hsl = $this->db->query("UPDATE barang_reseller SET br_harga='$harga' WHERE br_id='$br_id'");
     		return $hsl;
		}

		function update_barang_non_reseller($bnr_id, $harga){
			$hsl = $this->db->query("UPDATE barang_non_reseller SET bnr_harga='$harga' WHERE bnr_id='$bnr_id'");
     		return $hsl;
		}

		function hapus_barang_R($barang_id){
			$this->db->trans_start();
				$this->db->query("DELETE FROM barang_reseller WHERE barang_id='$barang_id'");
	      	$this->db->trans_complete();
	        if($this->db->trans_status()==true)
	        return true;
	        else
	        return false;
		}

		function hapus_barang_NR($barang_id){
			$this->db->trans_start();
				$this->db->query("DELETE FROM barang WHERE barang_id='$barang_id'");
				$this->db->query("DELETE FROM barang_non_reseller WHERE barang_id='$barang_id'");
	      	$this->db->trans_complete();
	        if($this->db->trans_status()==true)
	        return true;
	        else
	        return false;
		}

		function getHargaReseller($barang_id){
			$hasil=$this->db->query("SELECT * FROM barang_reseller WHERE barang_id = '$barang_id'");
        	return $hasil;
		}

		function getAllBarang(){
			$hasil=$this->db->query("SELECT barang.*,DATE_FORMAT(barang_tanggal,'%d/%m/%Y %H:%i') AS tanggal FROM barang ORDER BY barang_nama");
        	return $hasil;
		}
		function getAllBarangR(){
			$hasil=$this->db->query("SELECT barang.*,DATE_FORMAT(barang_tanggal,'%d/%m/%Y %H:%i') AS tanggal FROM barang WHERE barang_stock_akhir > 0 ORDER BY barang_nama");
        	return $hasil;
		}

		function getDataReseller(){
			$hasil=$this->db->query("SELECT a.*,DATE_FORMAT(barang_tanggal,'%d/%m/%Y %H:%i') AS tanggal FROM barang a WHERE a.barang_stock_akhir > 0 AND barang_level = 1");
        	return $hasil;
		}

		function getDataNonReseller1(){
			$hasil=$this->db->query("SELECT a.*,DATE_FORMAT(barang_tanggal,'%d/%m/%Y %H:%i') AS tanggal FROM barang a WHERE a.barang_stock_akhir > 0 AND barang_level = 2");
        	return $hasil;
		}

		function getDataNonReseller(){
			$hasil=$this->db->query("SELECT a.*,b.*,DATE_FORMAT(barang_tanggal,'%d/%m/%Y %H:%i') AS tanggal FROM barang a, barang_non_reseller b WHERE a.barang_id = b.barang_id");
        	return $hasil;
		}

		function getHistoryStock($barang_id){
			$hasil=$this->db->query("SELECT c.pemesanan_nama,a.stock_berkurang,a.barang_id,b.barang_nama,DATE_FORMAT(a.hsb_tanggal,'%d/%m/%Y %H:%i') AS tanggal FROM history_stock_barang a,barang b, pemesanan c WHERE a.barang_id = '$barang_id' AND a.barang_id = b.barang_id AND a.pemesanan_id = c.pemesanan_id");
        	return $hasil;
		}

		function update_stock($barang_id,$stock)
		{
			return $this->db->query("UPDATE `barang` SET `barang_stock_awal`=`barang_stock_awal`+$stock WHERE `barang_id`=$barang_id");
		}

	}
?>