<!-- Vendor js -->
<script src="<?php echo base_url(); ?>tw/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url(); ?>tw/assets/js/app.min.js"></script>

<!-- Select2-->

<script src="<?php echo base_url(); ?>tw/assets/js/plugins/select2/select2.full.min.js"></script>



<!-- DATATBLE -->



<script src="<?php echo base_url(); ?>tw/assets/js/datatable/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>tw/assets/js/datatable/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url(); ?>tw/assets/js/datatable/pdfmake.min.js"></script>

<script src="<?php echo base_url(); ?>tw/assets/js/datatable/vfs_fonts.js"></script>

<script src="<?php echo base_url(); ?>tw/assets/js/datatable/jszip.min.js"></script>
<!-- 
<script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script> -->








<script type="text/javascript">
	var base_urlx = "<?php echo base_url(); ?>";



	$(document).ready(function() {



		$(".select2").select2();

		$(".select2-placeholer").select2({

			allowClear: true

		});



	});
</script>



<script src="<?php echo base_url(); ?>tw/assets/js/com_producto/reporte_productos.js?v=<?php echo time(); ?>"></script>



</body>

</html>