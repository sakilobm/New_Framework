<?
$currentPage = Session::getCurrentPageIdentifier();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <? Session::loadTemplate('admin/_head'); ?>
</head>
<style>
    /* Custome Toast */
    .custom-toast {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        background-color: #7B66FF;
        color: var(--white);
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: var(--box-shadow);
        display: none;
        z-index: 1;
    }

    .custom-toast.show {
        display: block;
        animation: fadeOut 10s forwards;
        /* Adjust the duration as needed */
    }
</style>

<body>
    <div class="wrapper">
        <? Session::loadTemplate('dashbord/_sidebar') ?>
        <div class="main-panel">
            <? Session::loadTemplate('dashbord/_navbar') ?>
            <div class="content">

                <?php
                switch ($currentPage) {
                    case 'addPost':
                        Session::loadTemplate('admin/_addPost');
                        break;
                    case 'editPost':
                        Session::loadTemplate('admin/_editPost');
                        break;
                    case 'SeeAdmin':
                        Session::loadTemplate('admin/_SeeAdmin');
                        break;
                    case 'addNewAdmin':
                        Session::loadTemplate('admin/_addNewAdmin');
                        break;
                    case 'addCategory':
                        Session::loadTemplate('admin/_addCategory');
                        break;
                        // Default to dashboard if the page is not recognized
                    default:
                        Session::loadTemplate('admin/_dashboard');
                        break;
                }
                ?>
            </div>
        </div>
        <? Session::loadTemplate('dashbord/_footer') ?>
        <? Session::loadTemplate('dashbord/_mod') ?>
        <div id="customToast" class="custom-toast"></div>
    </div>

    <script src="<? get_config('base_path'); ?>/assets_admin/js/core/jquery.min.js"></script>
    <script src="<? get_config('base_path'); ?>/assets_admin/js/core/popper.min.js"></script>
    <script src="<? get_config('base_path'); ?>/assets_admin/js/core/bootstrap.min.js"></script>
    <script src="<? get_config('base_path'); ?>/assets_admin/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <!-- Place this tag in your head or just before your close body tag. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="<? get_config('base_path'); ?>/assets_admin/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="<? get_config('base_path'); ?>/assets_admin/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<? get_config('base_path'); ?>/assets_admin/js/black-dashboard.min.js?v=1.0.0"></script>
    <!-- Black Dashboard DEMO methods, don't include it in your project! -->
    <script src="<? get_config('base_path'); ?>/assets_admin/demo/demo.js"></script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<? get_config('base_path'); ?>/js/admin_dashboard.js"></script>
</body>

</html>