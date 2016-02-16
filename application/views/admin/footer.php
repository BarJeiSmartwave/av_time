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
        return confirm('You are about to time in.');
    });
    $('#timeOut').on('click', function () {
        return confirm('Are you sure to time out?');
    });
    $('#goToBreak').on('click', function () {
        return confirm('You are about to start break.');
    });
    $('#endBreak').on('click', function () {
        return confirm('Are you sure to end break?');
    });
    //time functions
    $('#btnPicture').on('click', function () {
        return confirm('Upload and change your picture?');
    });
    $('#btnUser').on('click', function () {
        return confirm('Save changes and update your user details?');
    });
    $('#btnAccount').on('click', function () {
        return confirm('Save changes and update your account details?');
    });
    // edit profile
    $('#deleteIp1').on('click', function () {
        return confirm('Delete network?');
    });
    $('#deleteIp2').on('click', function () {
        return confirm('Delete network?');
    });
    $('#deleteIp3').on('click', function () {
        return confirm('Delete network?');
    });
    $('#deleteIp4').on('click', function () {
        return confirm('Delete network?');
    });
    $('#deleteIp5').on('click', function () {
        return confirm('Delete network?');
    });
    //delete ip
</script>
</body>
</html>