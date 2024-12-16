<?
$currentPage = Session::getCurrentPageIdentifier();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <? Session::loadTemplate('admin/_head'); ?>
</head>

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
        <? Session::loadTemplate('core/_toastv3') ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<? get_config('base_path'); ?>assets/js/admin_dashboard.js"></script>
    <script src="<? get_config('base_path'); ?>assets/js/toastv3.js"></script>
</body>

</html>