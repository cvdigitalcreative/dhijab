<div class="container-fluid">
  <div class="row">
    <!-- Left Sidebar -->
    <div class="side-menu-fixed">
     <div class="scrollbar side-menu-bg">
      <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <!-- menu title -->
         <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">Website Components</li>
        <!-- All Form  -->
         <li>
          <a href="javascript:void(0);" data-toggle="collapse" data-target="#Barang">
            <div class="pull-left"><i class="ti-files"></i><span class="right-nav-text">Barang</span></div>
            <div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div>
          </a>
          <ul id="Barang" class="collapse" data-parent="#sidebarnav">
            <li> <a href="<?php echo base_url()?>Owner/Barang">Barang Customer</a> </li>
            <li> <a href="<?php echo base_url()?>Owner/Barang/Reseller">Barang Reseller</a> </li>
          </ul>
        </li>
        <li>
          <a href="<?php echo base_url()?>Owner/Transaksi"><i class="ti-calendar"></i><span class="right-nav-text">History Transaksi</span> </a>
        </li>
        <li>
          <a href="<?php echo base_url()?>Owner/Barang/pemesanan"><i class="ti-world"></i><span class="right-nav-text">Pemesanan</span> </a>
        </li>
        <li>
          <a href="<?php echo base_url()?>Owner/Stock"><i class="ti-calendar"></i><span class="right-nav-text">History Stock</span> </a>
        </li>
        <li>
          <a href="<?php echo base_url()?>Owner/User"><i class="ti-calendar"></i><span class="right-nav-text">Laporan Keuangan</span> </a>
        </li>
        <li>
          <a href="<?php echo base_url()?>Owner/User"><i class="ti-user"></i><span class="right-nav-text">User</span> </a>
        </li>
    </ul>
  </div> 
</div>
<!-- Left Sidebar End-->