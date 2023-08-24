
      <!-- latest jquery-->
      <script src="{{asset("/assets/js/jquery-3.2.1.min.js")}}"></script>
      <!-- Bootstrap js-->
      <script src="{{asset("/assets/js/bootstrap/popper.min.js")}}"></script>
      <script src="{{asset("/assets/js/bootstrap/bootstrap.js")}}"></script>
      <!-- Sidebar jquery-->

      <script src="{{asset("/assets/js/sidebar-menu.js")}}"></script>
      <!-- Theme js-->
      <script src="{{asset("/assets/js/script.js")}}"></script>
      <!-- Theme js-->
      <script src="{{asset("/assets/js/clipboard/clipboard.min.js")}}" ></script>
      <script src="{{asset("/assets/js/moment/moment.min.js")}}"></script>
      <script src="{{asset("/assets/js/bootstrap-datetimepicker/tempusdominus-bootstrap-4.min.js")}}"></script>

      @if ($info->vertical=="Y")
      <script  src="{{asset("/assets/js/vertical-menu.js")}}"></script>
      <script src="{{asset("/assets/js/jquery.drilldown.js")}}"></script>
      <script src="{{asset("/assets/js/megamenu.js")}}"></script>
      @endif

      <script src="{{asset("/assets/js/bootstrap-selectpicker/bootstrap-select.js")}}"></script>
      <script src="{{asset("/assets/js/bootstrap-selectpicker/i18n/defaults-es_ES.js")}}"></script>
      <script src="{{asset("/assets/js/jquery-validation/jquery.validate.min.js")}}"></script>
      <script src="{{asset("/assets/js/sweet-alert/sweetalert.min.js")}}"></script>
      <script src="{{asset("/assets/js/datatables/jquery.dataTables.min.js")}}"></script>
      <script src="{{asset("/assets/js/datatable-extension/dataTables.keyTable.min.js")}}"></script>
      <script src="{{asset("/assets/js/jquery-inputmask/jquery.inputmask.bundle.js")}}"></script>
      <script src="{{asset("assets/js/tooltip-init.js")}}" ></script>
      <script src="{{asset("/assets/js/jquery-initialize/jquery.initialize.min.js")}}"></script>
      <script src="{{asset("/assets/js/jquery.format/jquery.formatCurrency-1.4.0.js")}}"></script>
      <script src="{{asset("/assets/js/jquery.format/i18n/jquery.formatCurrency.all.js")}}"></script>

      <script src="{{asset("/assets/js/funciones_generales.js?")}}v=<?=rand(0,9999)?>"></script>
      @stack("js")
