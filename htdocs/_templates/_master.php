<!DOCTYPE html>
<html lang="en">

<head>
    <? Session::loadTemplate('core/_head') ?>
</head>

<body>
    <div class="black-background"></div>

    <? Session::loadTemplate('core/_nav') ?>
    <? Session::loadTemplate('core/_footer'); ?>
    <? Session::loadTemplate('core/_toastv3'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<? get_config('base_path') ?>/js/index.js"></script>
</body>

</html>