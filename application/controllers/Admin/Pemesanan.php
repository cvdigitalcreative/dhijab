<?php 
	/**
	 * 
	 */
	class Pemesanan extends CI_Controller
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
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Pemesanan";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $x['metode_pembayaran'] = $this->m_pemesanan->getAllMetpem();
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
		        $x['produksi'] = $this->m_barang->getdataProduksi();
		       $x['reseller'] = $this->m_barang->getAllBarangR();
		       $x['datapesanan'] = $this->m_pemesanan->getPemesanan();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_pemesanan',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function customer(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Pemesanan";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $x['metode_pembayaran'] = $this->m_pemesanan->getAllMetpem();
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
		        $x['produksi'] = $this->m_barang->getdataProduksi();
		       $x['reseller'] = $this->m_barang->getAllBarangR();
		       $x['datapesanan'] = $this->m_pemesanan->getPemesananCustomer();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_pemesanan_customer',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function savepemesananCustomer(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$nama_akun_pemesan = "-";
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
			$tanggal = $this->input->post('tanggal');
			$diskon = $this->input->post('diskon');
			$biaya_admin = $this->input->post('biaya_admin');
			$uang = $this->input->post('uang');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= $this->input->post('biaya_ongkir');
	  		$email_pemesanan=$this->input->post('email_pemesanan');
	  		$note=$this->input->post('note');
	  		$status=0;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
			

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/customer');		  	
 	  	}

 	  	function hapus_pesananCustomer(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$this->m_pemesanan->hapus_pesanan($pemesanan_id);
	  		echo $this->session->set_flashdata('msg','hapus');
	       	redirect('Admin/Pemesanan/customer');	
	  	}

	  	function statusCustomer(){
            $pemesanan_id = $this->input->post('pemesanan_id');
            $status_pemesanan=$this->input->post('status_pemesanan');
            $jumlah=$this->input->post('jumlah');
            if($status_pemesanan==0)
            {
            $status_pemesanan=1;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }else if($status_pemesanan==1)
            {
            $status_pemesanan=2;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
            else if($status_pemesanan==2)
            {
            $status_pemesanan=3;
             $this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
             redirect('Admin/Pemesanan/customer');	
        }

        function reseller(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Pemesanan";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $x['metode_pembayaran'] = $this->m_pemesanan->getAllMetpem();
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
		        $x['produksi'] = $this->m_barang->getdataProduksi();
		       $x['reseller'] = $this->m_barang->getAllBarangR();
		       $x['datapesanan'] = $this->m_pemesanan->getPemesananreseller();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_pemesanan_reseller',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function savepemesananreseller(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$nama_akun_pemesan = $this->input->post('nama_akun_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
			$tanggal = $this->input->post('tanggal');
			$diskon = $this->input->post('diskon');
			$biaya_admin = $this->input->post('biaya_admin');
			$uang = $this->input->post('uang');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= $this->input->post('biaya_ongkir');
	  		$email_pemesanan=$this->input->post('email_pemesanan');
	  		$note=$this->input->post('note');
	  		$status=0;
	  		$level = 2;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
			
	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barangR($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/reseller');		  	
 	  	}

 	  	function hapus_pesananreseller(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$this->m_pemesanan->hapus_pesanan($pemesanan_id);
	  		echo $this->session->set_flashdata('msg','hapus');
	       	redirect('Admin/Pemesanan/reseller');	
	  	}

	  	function statusreseller(){
            $pemesanan_id = $this->input->post('pemesanan_id');
            $status_pemesanan=$this->input->post('status_pemesanan');
            $jumlah=$this->input->post('jumlah');
            if($status_pemesanan==0)
            {
            $status_pemesanan=1;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }else if($status_pemesanan==1)
            {
            $status_pemesanan=2;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
            else if($status_pemesanan==2)
            {
            $status_pemesanan=3;
             $this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
             redirect('Admin/Pemesanan/reseller');	
        }

        function produksi(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Pemesanan";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $x['metode_pembayaran'] = $this->m_pemesanan->getAllMetpem();
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
		        $x['produksi'] = $this->m_barang->getdataProduksi();
		       $x['reseller'] = $this->m_barang->getAllBarangR();
		       $x['datapesanan'] = $this->m_pemesanan->getPemesananproduksi();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_pemesanan_produksi',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function savepemesananproduksi(){
	  		$nama_pemesan = "admin";
	  		$nama_akun_pemesan ="-";
	  		$no_hp = "-";
	  		$alamat = "-";
	  		$asal_transaksi = "6";
	  		$kurir ="6";
	  		$metpem = "1";
			$tanggal = $this->input->post('tanggal');
			$uang = "0";
	  		$level = 3;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= "0";
	  		$email_pemesanan="-";
	  		$note=$this->input->post('note');
	  		$status=3;
	  		$diskon = 0;
			$biaya_admin = 0;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
	  		$size = sizeof($barang_id);
	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barangP($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}
	  		$a = $this->m_list_barang->SUMLBNR($pemesanan_id)->row_array();
	  		$jumlah=$a['total_keseluruhan'];
	  		$this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/produksi');		  	
 	  	}

 	  	function hapus_pesananproduksi(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$this->m_pemesanan->hapus_pesanan($pemesanan_id);
	  		echo $this->session->set_flashdata('msg','hapus');
	       	redirect('Admin/Pemesanan/produksi');	
	  	}

	  	function statusproduksi(){
            $pemesanan_id = $this->input->post('pemesanan_id');
            $status_pemesanan=$this->input->post('status_pemesanan');
            $jumlah=$this->input->post('jumlah');
           if($status_pemesanan==0)
            {
            $status_pemesanan=1;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }else if($status_pemesanan==1)
            {
            $status_pemesanan=2;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
            else if($status_pemesanan==2)
            {
            $status_pemesanan=3;
             $this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
             redirect('Admin/Pemesanan/produksi');	
        }


        function konfirmasi_pesanan(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Pemesanan";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $x['metode_pembayaran'] = $this->m_pemesanan->getAllMetpem();
		       $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
		        $x['produksi'] = $this->m_barang->getdataProduksi();
		       $x['reseller'] = $this->m_barang->getAllBarangR();
		       $x['datapesanan'] = $this->m_pemesanan->getPemesananKonfirmasi();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_pemesanan_konfirmasi_pesanan',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}
	  	function savepemesanankonfirmasi_pesananCustomer(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$nama_akun_pemesan = "-";
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
			$tanggal = $this->input->post('tanggal');
			$diskon = $this->input->post('diskon');
			$biaya_admin = $this->input->post('biaya_admin');
			$uang = $this->input->post('uang');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= $this->input->post('biaya_ongkir');
	  		$email_pemesanan=$this->input->post('email_pemesanan');
	  		$note=$this->input->post('note');
	  		$status=0;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
			

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/konfirmasi_pesanan');		  	
 	  	}

 	  	function savepemesanankonfirmasi_pesananReseller(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$nama_akun_pemesan = $this->input->post('nama_akun_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
			$tanggal = $this->input->post('tanggal');
			$diskon = $this->input->post('diskon');
			$biaya_admin = $this->input->post('biaya_admin');
			$uang = $this->input->post('uang');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= $this->input->post('biaya_ongkir');
	  		$email_pemesanan=$this->input->post('email_pemesanan');
	  		$note=$this->input->post('note');
	  		$status=0;
	  		$level = 2;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
			
	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barangR($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/konfirmasi_pesanan');		  	
 	  	}

	  	function savepemesanankonfirmasi_pesananProduksi(){
	  		$nama_pemesan = "admin";
	  		$nama_akun_pemesan ="-";
	  		$no_hp = "-";
	  		$alamat = "-";
	  		$asal_transaksi = "6";
	  		$kurir ="6";
	  		$metpem = "1";
			$tanggal = $this->input->post('tanggal');
			$uang = "0";
	  		$level = 3;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= "0";
	  		$email_pemesanan="-";
	  		$note=$this->input->post('note');
	  		$status=3;
	  		$diskon = 0;
			$biaya_admin = 0;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
	  		$size = sizeof($barang_id);
	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barangP($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  		}
	  		$a = $this->m_list_barang->SUMLBNR($pemesanan_id)->row_array();
	  		$jumlah=$a['total_keseluruhan'];
	  		$this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/konfirmasi_pesanan');		  	
 	  	}

 	  	function hapus_pesanankonfirmasi_pesanan(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$this->m_pemesanan->hapus_pesanan($pemesanan_id);
	  		echo $this->session->set_flashdata('msg','hapus');
	       	redirect('Admin/Pemesanan/konfirmasi_pesanan');	
	  	}

	  	function statuskonfirmasi_pesanan(){
            $pemesanan_id = $this->input->post('pemesanan_id');
            $status_pemesanan=$this->input->post('status_pemesanan');
            
            if($status_pemesanan==0)
            {
            $status_pemesanan=1;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }else if($status_pemesanan==1)
            {
            $status_pemesanan=2;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
            else if($status_pemesanan==2)
            {
            $status_pemesanan=3;
             $this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
             redirect('Admin/Pemesanan/konfirmasi_pesanan');	
        }


	  	function savepemesananNR(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$nama_akun_pemesan = "-";
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
			$tanggal = $this->input->post('tanggal');
			$diskon = $this->input->post('diskon');
			$biaya_admin = $this->input->post('biaya_admin');
			$uang = $this->input->post('uang');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= $this->input->post('biaya_ongkir');
	  		$email_pemesanan=$this->input->post('email_pemesanan');
	  		$note=$this->input->post('note');
	  		$status=0;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan');		  	
 	  	}

 	  	function tambahpesananNR(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$level = 2;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect("Admin/Pemesanan/list_barang/$pemesanan_id/$level");		  	
 	  	}

 	  	function tambahpesananR(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');

	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barang($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect("Admin/Pemesanan/list_barang/$pemesanan_id/$level");		  	
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

	  	function hapus_pesanan(){
	  		$pemesanan_id = $this->input->post('pemesanan_id');
	  		$this->m_pemesanan->hapus_pesanan($pemesanan_id);
	  		echo $this->session->set_flashdata('msg','hapus');
	       	redirect('Admin/Pemesanan');	
	  	}

 	  	function savepemesananR(){
	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$nama_akun_pemesan = $this->input->post('nama_akun_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metpem = $this->input->post('metpem');
			$tanggal = $this->input->post('tanggal');
			$diskon = $this->input->post('diskon');
			$biaya_admin = $this->input->post('biaya_admin');
			$uang = $this->input->post('uang');
	  		$level = 1;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= $this->input->post('biaya_ongkir');
	  		$email_pemesanan=$this->input->post('email_pemesanan');
	  		$note=$this->input->post('note');
	  		$status=0;
	  		$level = 2;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
			
	  		$size = sizeof($barang_id);

	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barangR($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}

	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan');		  	
 	  	}

 	  	function savepemesananP(){
	  		$nama_pemesan = "admin";
	  		$nama_akun_pemesan ="-";
	  		$no_hp = "-";
	  		$alamat = "-";
	  		$asal_transaksi = "6";
	  		$kurir ="6";
	  		$metpem = "1";
			$tanggal = $this->input->post('tanggal');
			$uang = "0";
	  		$level = 3;
	  		$barang_id = $this->input->post('barang');
	  		$qty = $this->input->post('qty');
	  		$biaya_ongkir= "0";
	  		$email_pemesanan="-";
	  		$note=$this->input->post('note');
	  		$status=3;
	  		$diskon = 0;
			$biaya_admin = 0;
	  		$pemesanan_id=$this->m_pemesanan->save_pesanan($nama_pemesan,$tanggal,$no_hp,$alamat,$level,$kurir,$asal_transaksi,$metpem,$uang,$biaya_ongkir,$email_pemesanan,$note,$status,$biaya_admin,$diskon,$nama_akun_pemesan);
	  		$size = sizeof($barang_id);
	  		for($i=0; $i < $size; $i++){
	  			$this->m_list_barang->save_list_barangP($pemesanan_id,$qty[$i],$barang_id[$i],$level);
	  			$this->m_barang->saveStok($barang_id[$i], $qty[$i], 1);
	  		}
	  		$a = $this->m_list_barang->SUMLBNR($pemesanan_id)->row_array();
	  		$jumlah=$a['total_keseluruhan'];
	  		$this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan');		  	
 	  	}

 	  	function edit_pesanan(){
 	  		$pemesanan_id = $this->input->post('pemesanan_id');
 	  		$nama_pemesan = $this->input->post('nama_pemesan');
	  		$no_hp = $this->input->post('hp');
	  		$alamat = $this->input->post('alamat');
	  		$asal_transaksi = $this->input->post('at');
	  		$kurir = $this->input->post('kurir');
	  		$metode_pembayaran = $this->input->post('mp');
	  		// $tanggal = $this->input->post('tanggal');

	  		$this->m_pemesanan->edit_pesanan($pemesanan_id,$nama_pemesan,$no_hp,$alamat,$kurir,$asal_transaksi,$metode_pembayaran);
	  		echo $this->session->set_flashdata('msg','update');
	       	redirect('Admin/Pemesanan');	
	  	}

 	  	function list_barang($pemesanan_id){
 	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
 	  		   $level = $this->uri->segment(5);
 	  		  		$y['title'] = "List Barang Pemesan";
 	  		   	   $x['p_id'] = $pemesanan_id;
 	  		   	   $x['lvl'] =$level;	
 	  		   	   $x['listbarang'] = $this->m_list_barang->get_list_barang($pemesanan_id);
 	  		   	   $a = $this->m_list_barang->SUMLBNR($pemesanan_id)->row_array();
 	  		   	   $x['nonreseller'] = $this->m_barang->getDataNonReseller1();
 	  		   	   $x['jumlah'] = $a['total_keseluruhan'];
			       $this->load->view('v_header',$y);
			       $this->load->view('admin/v_sidebar');
			       $this->load->view('admin/v_list_barang',$x);	
		       
		    }
		    else{
		       redirect('Login');
		    }
 	  	}

 	  	function Cetak_Invoice($pemesanan_id){
 	  		$level = $this->uri->segment(5);
 	  		   if($level == 1){
 	  		   	$y['title'] = "List Barang Pemesan";
 	  		   	   $x['p_id'] = $pemesanan_id;
 	  		   	   $x['lvl'] =$level;	
	 	  		   $x['listbarang'] = $this->m_list_barang->getLBRbyid($pemesanan_id);	
	 	  		   $x['pemesan'] = $this->m_pemesanan->getIdbyid($pemesanan_id);
	 	  		    $a = $this->m_pemesanan->getIdbyid($pemesanan_id)->row_array();
 	  		   	   $x['kurir'] = $a['kurir_nama'];
 	  		   	   $x['mp_nama'] = $a['mp_nama'];
 	  		  	   $x['nama'] = $this->session->userdata('nama');
			       $this->load->view('admin/v_cetak_invoice',$x);
 	  		   }elseif($level == 2){
 	  		   	   $y['title'] = "List Barang Pemesan";
 	  		   	   $x['p_id'] = $pemesanan_id;
 	  		   	   $x['lvl'] =$level;	
 	  		   	   $x['listbarang'] = $this->m_list_barang->getLBNRbyid($pemesanan_id);
 	  		   	   $x['pemesan'] = $this->m_pemesanan->getIdbyid($pemesanan_id);
 	  		   	   $a = $this->m_pemesanan->getIdbyid($pemesanan_id)->row_array();
 	  		   	   $x['kurir'] = $a['kurir_nama'];
 	  		   	   $x['mp_nama'] = $a['mp_nama'];
 	  		   	   $x['nama'] = $this->session->userdata('nama');
			       $this->load->view('admin/v_cetak_invoice',$x);
 	  		   }
 	  	}

	  	function asal_transaksi(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Asal Transaksi";
		       $x['asal_transaksi'] = $this->m_pemesanan->getAllAT();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_asal_transaksi',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function saveAT(){
	  		$at_nama = $this->input->post('at_nama');
	  		$this->m_pemesanan->save_at($at_nama);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/asal_transaksi');
	  	}

	  	function updateAT(){
	  		$id = $this->input->post('at_id');
	  		$at_nama = $this->input->post('at_nama');
	  		$this->m_pemesanan->update_at($id,$at_nama);
	  		echo $this->session->set_flashdata('msg','update');
	       	redirect('Admin/Pemesanan/asal_transaksi');
	  	}

	  	function hapusAT(){
	  		$id = $this->input->post('at_id');
	  		$this->m_pemesanan->hapus_at($id);
	  		echo $this->session->set_flashdata('msg','delete');
	       	redirect('Admin/Pemesanan/asal_transaksi');
	  	}

	  	function kurir(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Kurir";
		       $x['kurir'] = $this->m_pemesanan->getAllkurir();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_kurir',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function savekurir(){
	  		$kurir_nama = $this->input->post('kurir_nama');
	  		$this->m_pemesanan->save_kurir($kurir_nama);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/kurir');
	  	}

	  	function updatekurir(){
	  		$id = $this->input->post('kurir_id');
	  		$kurir_nama = $this->input->post('kurir_nama');
	  		$this->m_pemesanan->update_kurir($id,$kurir_nama);
	  		echo $this->session->set_flashdata('msg','update');
	       	redirect('Admin/Pemesanan/kurir');
	  	}

	  	function hapuskurir(){
	  		$id = $this->input->post('kurir_id');
	  		$this->m_pemesanan->hapus_kurir($id);
	  		echo $this->session->set_flashdata('msg','delete');
	       	redirect('Admin/Pemesanan/kurir');
	  	}

	  	function metode_pembayaran(){
	  		if($this->session->userdata('akses') == 2 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Metode Pembayaran";
		       $x['metpem'] = $this->m_pemesanan->getAllMetpem();
		       $this->load->view('v_header',$y);
		       $this->load->view('admin/v_sidebar');
		       $this->load->view('admin/v_metode_pembayaran',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function saveMetodePembayaran(){
	  		$metpem_nama = $this->input->post('mp_nama');
	  		$this->m_pemesanan->save_Metpem($metpem_nama);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Admin/Pemesanan/metode_pembayaran');
	  	}

	  	function updateMetodePembayaran(){
	  		$id = $this->input->post('mp_id');
	  		$metpem_nama = $this->input->post('mp_nama');
	  		$this->m_pemesanan->update_Metpem($id,$metpem_nama);
	  		echo $this->session->set_flashdata('msg','update');
	       	redirect('Admin/Pemesanan/metode_pembayaran');
	  	}

	  	function hapusMetodePembayaran(){
	  		$id = $this->input->post('mp_id');
	  		$this->m_pemesanan->hapus_Metpem($id);
	  		echo $this->session->set_flashdata('msg','delete');
	       	redirect('Admin/Pemesanan/metode_pembayaran');
		  }
		  function status(){
            $pemesanan_id = $this->input->post('pemesanan_id');
            $status_pemesanan=$this->input->post('status_pemesanan');
            $jumlah=$this->input->post('jumlah');
            if($status_pemesanan==0)
            {
            $status_pemesanan=1;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }else if($status_pemesanan==1)
            {
            $status_pemesanan=2;
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
            else if($status_pemesanan==2)
            {
            $status_pemesanan=3;
             $this->m_pemesanan->insert_uang_masuk($pemesanan_id,$jumlah);
            $this->m_pemesanan->status_pesanan($pemesanan_id,$status_pemesanan);
            }
             redirect('Admin/pemesanan');	
        
        }
	}
?>