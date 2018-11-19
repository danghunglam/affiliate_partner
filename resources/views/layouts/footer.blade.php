<!-- Bootstrap core JavaScript-->
<script src="{{ mix('js/jquery.min.js') }}"></script>
<script src="{{ mix('js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ mix('js/jquery.easing.min.js') }}"></script>

<!--Vuejs-->
<script src="{{ URL::asset('bower_component/vue/dist/vue.min.js') }}"></script>

<!--Axios-->
<script src="{{ URL::asset('bower_component/axios/dist/axios.min.js') }}"></script>

<!-- Page level plugin JavaScript-->

<script src="{{ mix('js/jquery.dataTables.js') }}"></script>
<script src="{{ mix('js/dataTables.bootstrap4.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ mix('js/sb-admin.min.js') }}"></script>

<!-- Demo scripts for this page-->
<script src="{{ mix('js/datatables-demo.js') }}"></script>

@yield('footer_extend')