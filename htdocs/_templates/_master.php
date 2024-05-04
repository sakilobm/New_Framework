<!DOCTYPE html>
<html lang="en">

<head>
    <? Session::loadTemplate('_head') ?>
</head>

<body>
    <div class="black-background"></div>

    <? Session::loadTemplate('_nav') ?>
    <?Session::loadTemplate('_footer');?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<? get_config('base_path') ?>/js/index.js"></script>
</body>

</html>