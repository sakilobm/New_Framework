<!DOCTYPE html>
<html lang="en">

<head>
    <? Session::loadTemplate('_head') ?>
</head>

<body>
    <div class="black-background"></div>

    <? Session::loadTemplate('_nav') ?>
    <?
    // <!-- Post Type 1 -->
    Session::loadTemplate('_postType1');
    // <!-- Post Type 2 -->
    Session::loadTemplate('_postType2');
    // <!-- Post Type 3 -->
    Session::loadTemplate('_postType3');
    // <!-- Slider -->
    // Session::loadTemplate('_slider');
    Session::loadTemplate('_footer');
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<? get_config('base_path') ?>/js/index.js"></script>
</body>

</html>