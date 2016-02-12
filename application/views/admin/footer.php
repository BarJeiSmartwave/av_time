<!-- jQuery -->
<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

<!-- data tables -->
<script src="<?php echo base_url('assets/data-tables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/data-tables/js/dataTables.bootstrap.min.js'); ?>"></script>

<!-- clock -->
<script src="<?php echo base_url('assets/js/clock.js'); ?>"></script>

<script>
	$(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
	$('#dataTable').DataTable({
		responsive: true
	});
</script>
<!-- data table -->
<script>
    $('#timeIn').on('click', function () {
        return confirm('Confirm time in.');
    });
    $('#timeOut').on('click', function () {
        return confirm('Confirm time out.');
    });
    $('#goToBreak').on('click', function () {
        return confirm('Confirm start break.');
    });
    $('#endBreak').on('click', function () {
        return confirm('Confirm end break.');
    });
</script>
<!-- time functions  -->
</script>
</body>
</html>