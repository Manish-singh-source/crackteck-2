<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col fs-13 text-muted text-center">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> - Made by <a href="#!"
                    class="text-reset fw-semibold">Technofra</a>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>


<!-- Datatables js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

<!-- dataTables.bootstrap5 -->
<script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

<!-- buttons.colVis -->
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>

<!-- buttons.bootstrap5 -->
<script src="assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>

<!-- dataTables.keyTable -->
<script src="assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>

<!-- dataTable.responsive -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

<!-- dataTables.select -->
<script src="assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

<!-- Datatable Demo App Js -->
<script src="assets/js/pages/datatable.init.js"></script>


<!-- Apexcharts JS -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Widgets Init Js -->
<script src="assets/js/pages/crm-dashboard.init.js"></script>

<!-- Boxplot Charts Init Js -->
<script src="assets/js/pages/apexcharts-heatmap.init.js"></script>

<!-- for basic area chart -->
<script src="../../../apexcharts.com/samples/assets/stock-prices.js"></script>

<!-- Apexcharts Init Js -->
<script src="assets/js/pages/apexcharts-line.init.js"></script>
<!-- App js-->
<script src="assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        $(".delete-row").on("click", function() {
            $(this).parents("tr").hide();
        });
    });
</script>

@yield('scripts')

</body>


</html>