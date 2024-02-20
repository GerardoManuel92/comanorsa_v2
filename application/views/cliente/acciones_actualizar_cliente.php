
<script src="<?php echo base_url(); ?>tw/js/plugins/select2/select2.full.min.js"></script>
  <!--<script type="text/javascript" src="<?php //echo base_url(); ?>tw/js/moment/moment.min.js"> </script>
  <script type="text/javascript" src="<?php //echo base_url(); ?>tw/js/moment/moment-with-locales.js"> </script>-->
  
<script type="text/javascript">
		
	var base_urlx = "<?php echo base_url(); ?>";
	var iduserx = "<?php echo $this->session->userdata(IDUSERCOM); ?>";
	var idfpagox = "<?php echo $info_cliente->idfpago; ?>";
	var idcfdix = "<?php echo $info_cliente->idcfdi; ?>";
	var idregimenx = "<?php echo $info_cliente->idregimen; ?>";

</script>
<script src="<?php echo base_url(); ?>tw/js/com_cliente/actualizar_clientes.js?v=<?php echo time();?>"></script>

</body>
</html>