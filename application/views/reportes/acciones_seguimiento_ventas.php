
<!-- DATATBLE -->

<script src="<?php echo base_url(); ?>tw/js/datatable/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url(); ?>tw/js/datatable/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>tw/js/datatable/pdfmake.min.js"></script> 
<script src="<?php echo base_url(); ?>tw/js/datatable/vfs_fonts.js"></script> 
<script src="<?php echo base_url(); ?>tw/js/datatable/jszip.min.js"></script>

  
<script type="text/javascript">
		
	var base_urlx = "<?php echo base_url(); ?>";
	var iduserx = "<?php echo $this->session->userdata('idusercomanorsa'); ?>";

	var idcotx = "<?php echo $info->idcotizacion; ?>";

</script>
<script src="<?php echo base_url(); ?>tw/js/com_reportes/reporte_seguimiento.js?v=<?php echo time();?>"></script>

</body>
</html>