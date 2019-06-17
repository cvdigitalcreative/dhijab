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
			       $this->load->view('stok/v_cetak_invoice',$x);
 	  		   }elseif($level == 3){
 	  		   	   $y['title'] = "List Barang Pemesan";
 	  		   	   $x['p_id'] = $pemesanan_id;
 	  		   	   $x['lvl'] =$level;	
 	  		   	   $x['listbarang'] = $this->m_list_barang->getLBNRbyid($pemesanan_id);
 	  		   	   $x['pemesan'] = $this->m_pemesanan->getIdbyid($pemesanan_id);
 	  		   	   $a = $this->m_pemesanan->getIdbyid($pemesanan_id)->row_array();
 	  		   	   $x['kurir'] = $a['kurir_nama'];
 	  		   	   $x['mp_nama'] = $a['mp_nama'];
 	  		   	   $x['nama'] = $this->session->userdata('nama');
			       $this->load->view('stok/v_cetak_invoice',$x);
 	  		   }
 	  	}


	  	function kurir(){
	  		if($this->session->userdata('akses') == 3 && $this->session->userdata('masuk') == true){
		       $y['title'] = "Kurir";
			   $x['datapesanan'] = $this->m_pemesanan->getPemesanan();
		       $this->load->view('v_header',$y);
		       $this->load->view('stok/v_sidebar');
		       $this->load->view('stok/v_kurir',$x);
		    }
		    else{
		       redirect('Login');
		    }
	  	}

	  	function savekurir(){
	  		$kurir_nama = $this->input->post('kurir_nama');
	  		$this->m_pemesanan->save_kurir($kurir_nama);
	  		echo $this->session->set_flashdata('msg','success');
	       	redirect('Stok/Pemesanan/kurir');
	  	}

	  	function updatekurir(){
	  		$id = $this->input->post('kurir_id');
	  		$kurir_nama = $this->input->post('kurir_nama');
	  		$this->m_pemesanan->update_kurir($id,$kurir_nama);
	  		echo $this->session->set_flashdata('msg','update');
	       	redirect('Stok/Pemesanan/kurir');
	  	}

	  	function hapuskurir(){
	  		$id = $this->input->post('kurir_id');
	  		$this->m_pemesanan->hapus_kurir($id);
	  		echo $this->session->set_flashdata('msg','delete');
	       	redirect('Stok/Pemesanan/kurir');
	  	}

		  function status(){
            $pemesanan_id = $this->input->post('pemesanan_id');
            $status_eks=$this->input->post('status_eks');;
            if($status_eks==0)
            {
            $status_eks=1;
            $this->m_pemesanan->status_eks($pemesanan_id,$status_eks);
					}
             redirect('Stok/Pemesanan/Kurir');	
        
        }

}
?>