<footer class="footer py-4 text-center text-muted small bg-white border-top"> 
    &copy; <?php echo date('Y'); ?> FoodPicko Admin Dashboard. All rights reserved. 
</footer>

<footer class="sidebar-overlay"></footer>

<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('.left-sidebar').toggleClass('active');
        $('.sidebar-overlay').toggleClass('active');
        $('body').toggleClass('sidebar-toggled');
    });

    $('.sidebar-overlay').on('click', function () {
        $('.left-sidebar').removeClass('active');
        $(this).removeClass('active');
        $('body').removeClass('sidebar-toggled');
    });
});
</script>
