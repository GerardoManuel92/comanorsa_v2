<script type="text/javascript">
		
	var base_urlx = "<?php echo base_url(); ?>";
	//var iduserx = "<?php //echo $this->session->userdata('iduercomanorsa'); ?>";

	function cerrarSesion(){

	    var x = confirm("¿Realmente deseas cerrar la sesión?");

	    if( x==true ){

	      window.location.href = base_urlx+"Login/CerrarSesion/";
	      
	    }  

	}

</script>
</html>