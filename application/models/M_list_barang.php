<?php 

	/**
	 * 
	 */
	class M_list_barang extends CI_Model
	{
		
		function save_list_barang($pemesanan_id,$qty,$barang_id,$lvl){
			$this->db->trans_start();
				// $cek = $this->db->query("SELECT * FROM list_barang WHERE pemesanan_id = '$pemesanan_id' AND barang_id ='$barang_id'");
				// if($cek->num_rows > 0){

				// }
				$x = $this->db->query("SELECT id_jenis_barang,berat,harga_ecer,harga_grosir_3_11,harga_grosir_12_29,grosir_diatas_30 from kategori_barang,barang where barang.id_kategori_barang=kategori_barang.id_kategori_barang and barang.barang_id='$barang_id'")->row_array();
				
				$berat = $x['berat'];

				$harga=0;

				if($qty<3){
					$harga = $x['harga_ecer'];
				}else if($qty>=3 and $qty<=11){
					$harga = $x['harga_grosir_3_11'];
				}else if($qty>=12 and $qty<=29){
					$harga = $x['harga_grosir_12_29'];
				}else if($qty>=30){
					$harga = $x['grosir_diatas_30'];
				}

				$this->db->query("INSERT INTO list_barang(pemesanan_id,lb_qty,barang_id,lb_lvl,berat,harga) VALUES ('$pemesanan_id','$qty','$barang_id','$lvl','$berat','$harga')");
				$this->db->query("UPDATE barang SET barang_stok = barang_stok-'$qty' WHERE barang_id = '$barang_id'");
				$this->db->query("INSERT INTO history_stock_barang(pemesanan_id,barang_id,stock_berkurang,lvl) VALUES ('$pemesanan_id','$barang_id','$qty','$lvl')");
	      	$this->db->trans_complete();
	        if($this->db->trans_status()==true)
	        return true;
	        else
	        return false;
		}

		function save_list_barangR($pemesanan_id,$qty,$barang_id,$lvl){
			$this->db->trans_start();
				// $cek = $this->db->query("SELECT * FROM list_barang WHERE pemesanan_id = '$pemesanan_id' AND barang_id ='$barang_id'");
				// if($cek->num_rows > 0){

				// }
				$x = $this->db->query("SELECT berat,reseller from kategori_barang,barang where barang.id_kategori_barang=kategori_barang.id_kategori_barang and barang.barang_id='$barang_id'")->row_array();
				
				$berat = $x['berat'];

				$harga=$x['reseller'];;

				

				$this->db->query("INSERT INTO list_barang(pemesanan_id,lb_qty,barang_id,lb_lvl,berat,harga) VALUES ('$pemesanan_id','$qty','$barang_id','$lvl','$berat','$harga')");
				$this->db->query("UPDATE barang SET barang_stok = barang_stok-'$qty' WHERE barang_id = '$barang_id'");
				$this->db->query("INSERT INTO history_stock_barang(pemesanan_id,barang_id,stock_berkurang,lvl) VALUES ('$pemesanan_id','$barang_id','$qty','$lvl')");
	      	$this->db->trans_complete();
	        if($this->db->trans_status()==true)
	        return true;
	        else
	        return false;
		}


		function hapus_list_barang($pemesanan_id,$lb_id,$qty,$barang_id){
			$this->db->trans_start();
				$this->db->query("DELETE FROM list_barang WHERE lb_id='$lb_id'");
				$this->db->query("UPDATE barang SET barang_stock_akhir = barang_stock_akhir+'$qty' WHERE barang_id = '$barang_id'");
				$this->db->query("DELETE FROM history_stock_barang WHERE pemesanan_id='$pemesanan_id' AND barang_id = '$barang_id'");
	      	$this->db->trans_complete();
	        if($this->db->trans_status()==true)
	        return true;
	        else
	        return false;
		}

		function get_list_barang($pemesanan_id){
			$hasil=$this->db->query("SELECT a.lb_id,a.pemesanan_id,a.lb_qty,a.barang_id,b.pemesanan_nama,c.barang_nama,a.harga as bnr_harga, a.lb_qty * a.harga AS total FROM list_barang a, pemesanan b, barang c WHERE a.pemesanan_id = '$pemesanan_id'  AND a.pemesanan_id = b.pemesanan_id AND a.barang_id = c.barang_id  ORDER BY lb_id");
        	return $hasil;
		}

		function getLBNRbyid($pemesanan_id){
			$hasil=$this->db->query("SELECT a.lb_id,a.pemesanan_id,a.lb_qty,a.barang_id,b.pemesanan_nama,c.barang_nama,d.bnr_harga, a.lb_qty * d.bnr_harga AS total FROM list_barang a, pemesanan b, barang c, barang_non_reseller d WHERE a.pemesanan_id = '$pemesanan_id' AND lb_lvl =2 AND a.pemesanan_id = b.pemesanan_id AND a.barang_id = c.barang_id AND a.barang_id = d.barang_id ORDER BY lb_id");
        	return $hasil;
		}

		function SUMLBNR($pemesanan_id){
			$hasil=$this->db->query("SELECT SUM(a.lb_qty * a.harga) AS total_keseluruhan FROM list_barang a, pemesanan b, barang c, barang_non_reseller d WHERE a.pemesanan_id = '$pemesanan_id' AND a.pemesanan_id = b.pemesanan_id ORDER BY lb_id");
        	return $hasil;
		}


		function getLBRbyid($pemesanan_id){
			$x = $this->db->query("SELECT SUM(lb_qty) AS jumlah_barang FROM list_barang WHERE pemesanan_id = '$pemesanan_id'")->row_array();
			$jumlah = $x['jumlah_barang'];

			$hasil=$this->db->query("SELECT a.lb_id,a.pemesanan_id,a.lb_qty,a.barang_id,b.pemesanan_nama,c.barang_nama,d.br_harga,a.lb_qty * d.br_harga AS total FROM list_barang a, pemesanan b, barang c, barang_reseller d WHERE a.pemesanan_id = '$pemesanan_id' AND '$jumlah' = d.br_kuantitas AND a.pemesanan_id = b.pemesanan_id AND a.barang_id = c.barang_id AND a.barang_id = d.barang_id ORDER BY lb_id");
        	return $hasil;
		}

		function SUMLBR($pemesanan_id){
			$hasil=$this->db->query("SELECT SUM(a.lb_qty * d.br_harga) AS total_keseluruhan FROM list_barang a, pemesanan b, barang c, barang_reseller d WHERE a.pemesanan_id = '$pemesanan_id' AND a.lb_qty = d.br_kuantitas AND a.pemesanan_id = b.pemesanan_id AND a.barang_id = c.barang_id AND a.barang_id = d.barang_id ORDER BY lb_id ");
        	return $hasil;
		}
	}
?>