<?php
	/**
	 * 
	 */
	class M_pemesanan extends CI_Model
	{

		function save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir_id,$at_id,$mp_id,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon){
			$this->db->query("INSERT INTO pemesanan(pemesanan_nama,pemesanan_tanggal,pemesanan_hp,pemesanan_alamat,status_customer,kurir_id,at_id,mp_id,uang_kembalian,biaya_ongkir,email_pemesan,note,status_pemesanan,biaya_admin,diskon) VALUES ('$nama_pemesan','$tanggal','$no_hp','$alamat','$level','$kurir_id','$at_id','$mp_id','$uang','$biaya_ongkir','$email_pemesanan','$note','$status','$biaya_admin','$diskon')");
			$hsl=$this->db->insert_id();
			return $hsl;
		}

	

		function getPemesanan(){
			$hasil=$this->db->query("SELECT a.*,b.*,c.*,d.*,DATE_FORMAT(pemesanan_tanggal,'%d/%m/%Y') AS tanggal FROM pemesanan a, kurir b, asal_transaksi c, metode_pembayaran d WHERE a.kurir_id = b.kurir_id AND a.at_id = c.at_id AND a.mp_id = d.mp_id and a.status_pemesanan!=4  ORDER BY a.pemesanan_id DESC");
        	return $hasil;
		}

		function getPemesananCurdate(){
			date_default_timezone_set("Asia/Jakarta");
        	$cur_date = date("Y-m-d");
			$hasil=$this->db->query("SELECT a.*,b.*,c.*,d.*,DATE_FORMAT(pemesanan_tanggal,'%d/%m/%Y') AS tanggal FROM pemesanan a, kurir b, asal_transaksi c, metode_pembayaran d WHERE pemesanan_tanggal = '$cur_date' AND a.kurir_id = b.kurir_id AND a.at_id = c.at_id AND a.mp_id = d.mp_id ORDER BY a.pemesanan_id DESC");
        	return $hasil;
		}

		function getPemesananMonth($dari,$ke){
			$hasil=$this->db->query("SELECT a.*,b.*,c.*,DATE_FORMAT(pemesanan_tanggal,'%d/%m/%Y') AS tanggal FROM pemesanan a, kurir b, asal_transaksi c WHERE (a.pemesanan_tanggal BETWEEN '$dari' AND '$ke') AND a.kurir_id = b.kurir_id AND a.at_id = c.at_id ORDER BY a.pemesanan_id DESC");
        	return $hasil;
		}

		function getIdbyName($nama_pemesan){
			$hasil=$this->db->query("SELECT * FROM pemesanan WHERE pemesanan_nama='$nama_pemesan' ORDER BY pemesanan_id DESC LIMIT 1");
        	return $hasil;
		}

		function getIdbyid($pemesanan_id){
			$hasil=$this->db->query("SELECT a.*,b.*,c.*,d.*,DATE_FORMAT(pemesanan_tanggal,'%d/%m/%Y') AS tanggal FROM pemesanan a, kurir b, asal_transaksi c,  metode_pembayaran d WHERE pemesanan_id='$pemesanan_id' AND  a.kurir_id = b.kurir_id AND a.at_id = c.at_id AND a.mp_id = d.mp_id LIMIT 1");
        	return $hasil;
		}

		function edit_pesanan($pemesanan_id,$nama,$no_hp,$alamat,$kurir_id,$at_id,$mp_id){
			$hsl = $this->db->query("UPDATE pemesanan SET pemesanan_nama='$nama',pemesanan_hp='$no_hp',pemesanan_alamat='$alamat',kurir_id='$kurir_id',at_id='$at_id',mp_id = '$mp_id' WHERE pemesanan_id='$pemesanan_id'");
        	return $hsl;
		}

		function edit_pesanan1($pemesanan_id,$nama,$tanggal,$no_hp,$alamat,$kurir_id,$at_id,$mp_id){
			$hsl = $this->db->query("UPDATE pemesanan SET pemesanan_nama='$nama',pemesanan_tanggal = '$tanggal',pemesanan_hp='$no_hp',pemesanan_alamat='$alamat',kurir_id='$kurir_id',at_id='$at_id',mp_id = '$mp_id' WHERE pemesanan_id='$pemesanan_id'");
        	return $hsl;
		}

		function hapus_pesanan($pemesanan_id){
			$this->db->trans_start();
				$this->db->query("UPDATE pemesanan SET status_pemesanan=4 WHERE pemesanan_id='$pemesanan_id'");

				$data = $this->db->query("SELECT * FROM list_barang WHERE pemesanan_id='$pemesanan_id'");
				foreach ($data->result_array() as $i) {
					$qty = $i['lb_qty'];
					$barang_id = $i['barang_id'];
					$data_2= $this->db->query("SELECT barang_stok FROM barang WHERE barang_id='$barang_id'");
					foreach ($data_2->result_array() as $i) {
						$barang_stock_akhir=$i['barang_stok'];
					}
					$this->db->query("UPDATE barang SET barang_stok = ($barang_stock_akhir+$qty) WHERE barang_id = '$barang_id'");
				}
				$this->db->query("DELETE FROM list_barang WHERE pemesanan_id='$pemesanan_id'");
	      	$this->db->trans_complete();
	        if($this->db->trans_status()==true)
	        return true;
	        else
	        return false;
		}
		
		function getAllAT(){
			$hasil=$this->db->query("SELECT * FROM asal_transaksi");
        	return $hasil;
		}

		function save_at($nama){
			$hsl = $this->db->query("INSERT INTO asal_transaksi(at_nama) VALUES ('$nama')");
        	return $hsl;
		}

		function update_at($id,$nama){
			$hsl = $this->db->query("UPDATE asal_transaksi SET at_nama='$nama' WHERE at_id='$id'");
        	return $hsl;
		}

		function hapus_at($id){
	      	$hsl = $this->db->query("DELETE FROM asal_transaksi WHERE at_id='$id'");
	      	return $hsl;
    	}

    	function getAllMetpem(){
			$hasil=$this->db->query("SELECT * FROM metode_pembayaran");
        	return $hasil;
		}

		function save_Metpem($nama){
			$hsl = $this->db->query("INSERT INTO metode_pembayaran(mp_nama) VALUES ('$nama')");
        	return $hsl;
		}

		function update_Metpem($id,$nama){
			$hsl = $this->db->query("UPDATE metode_pembayaran SET mp_nama='$nama' WHERE mp_id='$id'");
        	return $hsl;
		}

		function hapus_Metpem($id){
	      	$hsl = $this->db->query("DELETE FROM metode_pembayaran WHERE mp_id='$id'");
	      	return $hsl;
    	}

    	function getAllkurir(){
			$hasil=$this->db->query("SELECT * FROM kurir");
        	return $hasil;
		}

		function save_kurir($nama){
			$hsl = $this->db->query("INSERT INTO kurir(kurir_nama) VALUES ('$nama')");
        	return $hsl;
		}

		function update_kurir($id,$nama){
			$hsl = $this->db->query("UPDATE kurir SET kurir_nama='$nama' WHERE 	kurir_id='$id'");
        	return $hsl;
		}

		function hapus_kurir($id){
	      	$hsl = $this->db->query("DELETE FROM kurir WHERE kurir_id='$id'");
	      	return $hsl;
    	}

    	function SUMR(){
    		return $this->db->query("SELECT SUM(a.lb_qty * d.br_harga) AS total_keseluruhan FROM list_barang a, pemesanan b, barang c, barang_reseller d WHERE  a.lb_qty = d.br_kuantitas AND a.pemesanan_id = b.pemesanan_id AND a.barang_id = c.barang_id AND a.barang_id = d.barang_id");
    	}

    	function SUMNR(){
    		return $this->db->query("SELECT SUM(a.lb_qty * d.bnr_harga) AS total_keseluruhan FROM list_barang a, pemesanan b, barang c, barang_non_reseller d WHERE a.pemesanan_id = b.pemesanan_id AND a.barang_id = c.barang_id AND a.barang_id = d.barang_id");
		}

		function status_pesanan($pemesanan_id,$status_pemesanan){
		
				return $this->db->query("UPDATE pemesanan SET status_pemesanan = '$status_pemesanan' WHERE pemesanan_id = '$pemesanan_id'");
			
		}

		function insert_uang_masuk($pemesanan_id,$jumlah){
		
					$hsl = $this->db->query("INSERT INTO uang_masuk(pemesanan_id,jumlah) VALUES ('$pemesanan_id','$jumlah')");

					return $hsl;
			
		}
		function status_eks($pemesanan_id,$status_eks){
		
			return $this->db->query("UPDATE pemesanan SET status_eks = '$status_eks' WHERE pemesanan_id = '$pemesanan_id'");
		
	}
	
	}
?>