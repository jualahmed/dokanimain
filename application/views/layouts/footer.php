
<footer class="main-footer" >
  <input name="ret_and_sel" type="hidden" id="ret_and_sel" value="<?php echo base_url();?>extra_controller/retrive_and_select" />
  <input name="ret_and_sel_with_id" type="hidden" id="ret_and_sel_with_id" value="<?php echo base_url();?>extra_controller/retrive_and_select_with_id" />
    <div class="pull-right hidden-xs" style="color: #405367;margin-top:5px;">
      &#169; <?php echo $this->tank_auth->get_shopname(); ?>, <?php echo $this->tank_auth->get_shopaddress(); ?>.
    </div>
  <p style="color: #405367;margin-top:5px;"><i class="fa fa-cog fa-spin fa-lg fa-fw"></i>Dokani Developed by 
    <span class="lead"> 
      <a href="http://www.itlabsolutions.com" target="_blank" id="companyTitle"> 
        <img id="footerLogo" style="width:30px;" src="<?php echo base_url();?>assets/img/itlablogo.png"/> IT Lab Solutions Ltd.<sup>&reg;</sup> 
      </a>
    </span> +8801842485222
  </p>
</footer>
 </div>

<script>
  var base_url="<?php echo base_url(); ?>";
  function formatDate(date) {
      var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();
      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;
      return [day,month,year].join('-');
  }
</script>
<script src="<?php echo base_url();?>assets/js/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.scrollbar.min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>

<?php if(isset($vuejscomp)){ ?>
  <script src="<?php echo base_url();?>assets/js/vuejs/vue.min.js"></script>
  <script src="https://unpkg.com/vue-select@3.0.0"></script>
  <script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
  <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
  <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
  <script src="<?php echo base_url();?>assets/js/vuejs/vuejscomp/<?php echo $vuejscomp ?>"></script>
<?php } ?>

</body>
</html>
