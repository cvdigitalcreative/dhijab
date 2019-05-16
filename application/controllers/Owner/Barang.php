<?php 
	/**
	 * 
	 */
	class Barang extends CI_Controller
	{
		
		function __construct()
	  	{
		    parent:: __construct();
		    if($this->session->userdata('masuk') !=TRUE){
		      $url=base_url('Login');
		      redirect($url);
		    };

		    $this->load->model('m_pemesanan');
		    $this->load->model('m_barang');
		    $this->load->model('m_list_barang');
		    $this->load->library('upload');
	  	}

	  	function index(){
	  		if($this->session->userdata('akses') == 1 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Barang Customer";
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller();
		       $this->load->view('v_header',$y);
		       $this->load->view('owner/v_sidebar');
		       $this->load->view('owner/v_barang_non_reseller',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function pemesanan(){
	  		if($this->session->userdata('akses') == 1 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Pemesanan";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $x['metode_pembayaran'] = $this->m_pemesanan->getAllMetpem();
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
		       $x['reseller'] = $this->m_barang->getAllBarangR();
		       $x['datapesanan'] = $this->m_pemesanan->getPemesanan();
		       $this->load->view('v_header',$y);
		       $this->load->view('owner/v_sidebar');
		       $this->load->view('owner/v_pemesanan_o',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function tambahpesananNR(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$level = 2;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect("Owner/Barang/list_barang/$pemesanan_id/$level");		  	
 	  	}

 	  	function hapuspesananlb(){
	  		$lb_id = $this->input->post('lb_id');
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$barang_id = $this->input->post('barang_id');
	  		$qty = $this->input->post('qty');
	  		$this->m_list_barang->hapus_list_barang($pemesanan_id,$lb_id,$qty,$barang_id);
	  		echo $this->session->set_flashdata('msg','delete');
	       	redirect($this->agent->referrer());
	  	}

 	  	function tambahpesananR(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect("Owner/Barang/list_barang/$pemesanan_id/$level");		  	
 	  	}



	  	function savepemesananNR(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
	  		$tanggal = $this->input->post('tanggal');
	  		$level = 2;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');

	  		$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem);
			$x=$this->m_pemesanan->getIdbyName($nama_pemesan);
			$z=$x->row_array();
			$pemesanan_id=$z['pemesanan_id'];

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Owner/Barang/pemesanan');		  	
 	  	}

 	  	function savepemesananR(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
	  		$level = 1;
	  		$tanggal = $this->input->post('tanggal');
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');

	  		$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem);
			$x=$this->m_pemesanan->getIdbyName($nama_pemesan);
			$z=$x->row_array();
			$pemesanan_id=$z['pemesanan_id'];

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Owner/Barang/pemesanan');	  	
 	  	}

 	  	function edit_pesanan(){
 	  		$pemesanan_id = $this->input->post('pemesanan_id');
 	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metode_pembayaran = $this->input->post('mp');
	  		$tanggal = $this->input->post('tanggal');

	  		$this->m_pemesanan->edit_pesanan1($pemesanan_id,$nama_pemesan,$tanggal,$no_hp,$alamat,$kurir,$asal_transaksi,$metode_pembayaran);
	  		echo $this->session->set_flashdata('msg','update');
	       	redirect('Owner/Barang/pemesanan');	
	  	}

	  	function hapus_pesanan(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$this->m_pemesanan->hapus_pesanan($pemesanan_id);
	  		echo $this->session->set_flashdata('msg','hapus');
	       	redirect('Owner/Barang/pemesanan');	
	  	}

 	  	function list_barang($pemesanan_id){
 	  		if($this->session->userdata('akses') == 1 && $this->session->userdata('masuk') == true){
 	  		   $level = $this->uri->segment(5);
 	  		   if($level == 1){
 	  		   	   $x['p_id'] = $pemesanan_id;
 	  		   	   $x['lvl'] =$level;	
	 	  		   $y['title'] = "List Barang Pemesan";
	 	  		   $x['listbarang'] = $this->m_list_barang->getLBRbyid($pemesanan_id);	
	 	  		   $x['reseller'] = $this->m_barang->getAllBarangR();
	 	  		   $a = $this->m_list_barang->SUMLBR($pemesanan_id)->row_array();
 	  		   	   $x['jumlah'] = $a['total_keseluruhan'];
			       $this->load->view('v_header',$y);
			       $this->load->view('admin/v_sidebar');
			       $this->load->view('admin/v_list_barang1',$x);
 	  		   }elseif($level == 2){
 	  		   	   $y['title'] = "List Barang Pemesan";
 	  		   	   $x['p_id'] = $pemesanan_id;
 	  		   	   $x['lvl'] =$level;	
 	  		   	   $x['listbarang'] = $this->m_list_barang->getLBNRbyid($pemesanan_id);
 	  		   	   $a = $this->m_list_barang->SUMLBNR($pemesanan_id)->row_array();
 	  		   	   $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
 	  		   	   $x['jumlah'] = $a['total_keseluruhan'];
			       $this->load->view('v_header',$y);
			       $this->load->view('admin/v_sidebar');
			       $this->load->view('admin/v_list_barang',$x);		
 	  		   }
		       
		    }
		    else{
		       redirect('Login');
		    }
 	  	}



	  	function Reseller(){
	  		if($this->session->userdata('akses') == 1 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Barang Reseller";
		       $x['reseller'] = $this->m_barang->getDataReseller();
		       $x['barang'] = $this->m_barang->getAllBarang();
		       $this->load->view('v_header',$y);
		       $this->load->view('owner/v_sidebar');
		       $this->load->view('owner/v_barang_reseller',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function Harga_Reseller($barang_id){
	  		if($this->session->userdata('akses') == 1 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Harga Barang";
		       $x['harga'] = $this->m_barang->getHargaReseller($barang_id);
		       $this->load->view('v_header',$y);
		       $this->load->view('owner/v_sidebar');
		       $this->load->view('owner/v_harga_reseller',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function update_harga_reseller(){
	  		$br_id = $this->input->post('br_id');
	  		$barang_id = $this->input->post('barang_id');
			$harga = str_replace(".", "", $this->input->post('harga'));
			$this->m_barang->update_harga($br_id,$harga);
			echo $this->session->set_flashdata('msg','update');
	        redirect("Owner/Barang/Harga_Reseller/$barang_id");
	  	}

	  	function s_barang_reseller(){
	  		$minqty = $this->input->post('minqty');
			$maxqty = $this->input->post('maxqty');
			$harga = $this->input->post('harga');
			$barang_id = $this->input->post('barang');

			$qty = sizeof($minqty);

			for($i=0; $i < $qty; $i++)
			{
				for ($kuantitas=$minqty[$i]; $kuantitas <= $maxqty[$i]; $kuantitas++) { 
					$this->m_barang->savebarangreseller($barang_id, $kuantitas, $harga[$i]);
				}
			}
			echo $this->session->set_flashdata('msg','success');
	        redirect('Owner/Barang/Reseller');
	  	}

	  	function edit_reseller(){
	  		//Config Upload File 
			$config['upload_path'] = './assets/image_barang/'; //Tempat menyimpan file
	        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //tipe filenya 
	        $config['max_size']             = 0; //size limits

	        $this->upload->initialize($config);
	        if(!empty($_FILES['filefoto']['name']))// cek apakah file ada di form
	        {
	            if ($this->upload->do_upload('filefoto'))// cek kondisi do_upload == true
	            {
	                $gbr = $this->upload->data(); // upload data 
	                $gambar=$gbr['file_name']; //ambil file nama
			  		$nama_barang = $this->input->post('nama_barang');
			  		$stock_awal = $this->input->post('stock_awal');
			  		$stock_akhir = $this->input->post('stock_akhir');
			  		$barang_id=$this->input->post('barang_id');
			  		$images=$this->input->post('barang_foto');
			  		$harga_modal = str_replace(".", "", $this->input->post('harga_modal'));
                    $path='./assets/images/'.$images;
                    unlink($path);

			  		$this->m_barang->update_barangImage($barang_id,$nama_barang, $stock_awal, $stock_akhir, $harga_modal, $gambar);
			  		// $this->m_barang->update_barang_reseller($bnr_id, $harga_non_reseller);

					echo $this->session->set_flashdata('msg','success_reseller');
	                redirect('Owner/Barang/Reseller');
				}else{
	                echo $this->session->set_flashdata('msg','warning');
	                redirect('Owner/Barang/Reseller');
	            }         
	        }else{
			  	$nama_barang = $this->input->post('nama_barang');
			  	$stock_awal = $this->input->post('stock_awal');
			  	$stock_akhir = $this->input->post('stock_akhir');
			  	$barang_id=$this->input->post('barang_id');
			  	$harga_modal = str_replace(".", "", $this->input->post('harga_modal'));
			  	$this->m_barang->update_barang_noImage($barang_id,$nama_barang, $stock_awal, $stock_akhir, $harga_modal);
			  	// $this->m_barang->update_barang_non_reseller($bnr_id, $harga_non_reseller);
	        	echo $this->session->set_flashdata('msg','success_non_reseller');
				redirect('Owner/Barang/Reseller');
			}
	  	}

	  	function hapus_reseller(){
	  		$barang_id=$this->input->post('barang_id');
            $this->m_barang->hapus_barang_R($barang_id);
	        echo $this->session->set_flashdata('msg','delete');
			redirect('Owner/Barang/Reseller');
	  	}

	  	function s_barang_non_reseller(){
	  		//Config Upload File 
			$config['upload_path'] = './assets/image_barang/'; //Tempat menyimpan file
	        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //tipe filenya 
	        $config['max_size']             = 0; //size limits

	        $this->upload->initialize($config);
	        if(!empty($_FILES['filefoto']['name']))// cek apakah file ada di form
	        {
	            if ($this->upload->do_upload('filefoto'))// cek kondisi do_upload == true
	            {
	                $gbr = $this->upload->data(); // upload data 
	                $gambar=$gbr['file_name']; //ambil file nama
			  		$harga_non_reseller =str_replace(".", "",$this->input->post('harga_normal')) ;
			  		$nama_barang = $this->input->post('nama_barang');
			  		$stock_awal = $this->input->post('stock_awal');
			  		$stock_akhir = $this->input->post('stock_akhir');
			  		$barang_level = 2;
			  		$harga_modal = str_replace(".", "", $this->input->post('harga_modal'));

			  		$this->m_barang->savebarang($nama_barang, $stock_awal, $stock_akhir, $harga_modal, $barang_level, $gambar);
			  		$cadmin=$this->m_barang->getIdbyName($nama_barang);
			  		$xcadmin=$cadmin->row_array();
			  		$barang_id=$xcadmin['barang_id'];
			  		$this->m_barang->savebarangnonreseller($barang_id, $harga_non_reseller);

					echo $this->session->set_flashdata('msg','success_non_reseller');
	                redirect('Owner/Barang');
				}else{
	                echo $this->session->set_flashdata('msg','warning');
	                redirect('Owner/Barang');
	            }         
	        }else{
	        	echo $this->session->set_flashdata('msg','eroor');
				redirect('Owner/Barang');
			}
	  	}

	  	function edit_non_reseller(){
	  		//Config Upload File 
			$config['upload_path'] = './assets/image_barang/'; //Tempat menyimpan file
	        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //tipe filenya 
	        $config['max_size']             = 0; //size limits

	        $this->upload->initialize($config);
	        if(!empty($_FILES['filefoto']['name']))// cek apakah file ada di form
	        {
	            if ($this->upload->do_upload('filefoto'))// cek kondisi do_upload == true
	            {
	                $gbr = $this->upload->data(); // upload data 
	                $gambar=$gbr['file_name']; //ambil file nama
			  		$harga_non_reseller =str_replace(".", "",$this->input->post('harga_normal')) ;
			  		$nama_barang = $this->input->post('nama_barang');
			  		$stock = $this->input->post('stock');
			  		$barang_id=$this->input->post('barang_id');
			  		$bnr_id=$this->input->post('bnr_id');
			  		$images=$this->input->post('barang_foto');
                    $path='./assets/images/'.$images;
                    unlink($path);
			  		$harga_modal = str_replace(".", "", $this->input->post('harga_modal'));
			  		$diskon = $this->input->post('diskon');

			  		$this->m_barang->update_barangImage($barang_id,$nama_barang, $stock, $harga_modal, $gambar, $diskon);
			  		$this->m_barang->update_barang_non_reseller($bnr_id, $harga_non_reseller);

					echo $this->session->set_flashdata('msg','success_non_reseller');
	                redirect('Owner/Barang');
				}else{
	                echo $this->session->set_flashdata('msg','warning');
	                redirect('Owner/Barang');
	            }         
	        }else{
	        	$harga_non_reseller =str_replace(".", "",$this->input->post('harga_normal')) ;
			  	$nama_barang = $this->input->post('nama_barang');
			  	$stock = $this->input->post('stock');
			  	$barang_id=$this->input->post('barang_id');
			  	$bnr_id=$this->input->post('bnr_id');
			  	$diskon = $this->input->post('diskon');
			  	$harga_modal = str_replace(".", "", $this->input->post('harga_modal'));
			  	$this->m_barang->update_barang_noImage($barang_id,$nama_barang, $stock, $harga_modal, $diskon);
			  	$this->m_barang->update_barang_non_reseller($bnr_id, $harga_non_reseller);
	        	echo $this->session->set_flashdata('msg','success_non_reseller');
				redirect('Owner/Barang');
			}
	  	}

	  	function hapus_non_reseller(){
	  		$barang_id=$this->input->post('barang_id');
			$images=$this->input->post('barang_foto');
            $path='./assets/images/'.$images;
            unlink($path);
            $this->m_barang->hapus_barang_NR($barang_id);
	        echo $this->session->set_flashdata('msg','delete');
			redirect('Owner/Barang');
	  	}

	  	function history($barang_id){
 	  		if($this->session->userdata('akses') == 1 && $this->session->userdata('masuk') == true){
 	  			$y['title'] = "Stock";	
 	  		   	   $x['stock'] = $this->m_barang->getHistoryStock($barang_id,2);
			       $this->load->view('v_header',$y);
			       $this->load->view('owner/v_sidebar');
			       $this->load->view('owner/v_history_stock',$x);
 	  		   
		       
		    }
		    else{
		       redirect('Login');
		    }
 	  	}


	}
?>