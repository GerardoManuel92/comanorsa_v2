<script src="<?php echo base_url(); ?>tw/js/easyautocomplete/jquery.easy-autocomplete.js"></script>

<script src="<?php echo base_url(); ?>tw/js/plugins/select2/select2.full.min.js"></script>

<script src="<?php echo base_url(); ?>tw/js/plugins/datepicker/bootstrap-datepicker.js"></script>



<!-- DATATBLE -->



<script src="<?php echo base_url(); ?>tw/js/datatable/jquery.dataTables.min.js"></script> 

<script src="<?php echo base_url(); ?>tw/js/datatable/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url(); ?>tw/js/datatable/pdfmake.min.js"></script> 

<script src="<?php echo base_url(); ?>tw/js/datatable/vfs_fonts.js"></script> 

<script src="<?php echo base_url(); ?>tw/js/datatable/jszip.min.js"></script>



<!--<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>-->



  <!--<script type="text/javascript" src="<?php //echo base_url(); ?>tw/js/moment/moment.min.js"> </script>

  <script type="text/javascript" src="<?php //echo base_url(); ?>tw/js/moment/moment-with-locales.js"> </script>-->

  

<script type="text/javascript">

		

	var base_urlx = "<?php echo base_url(); ?>";

	var iduserx = "<?php echo $this->session->userdata(IDUSERCOM); ?>";

  $(document).ready(function () {

		

  $(".select2").select2();

  $(".select2-placeholer").select2({

    allowClear: true

  });



  });


</script>

<script src="<?php echo base_url(); ?>tw/js/com_requerimientos/alta_rqv2.js?v=<?php echo time();?>"></script>



</body>

</html>