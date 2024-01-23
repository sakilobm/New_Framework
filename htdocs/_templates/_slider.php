<?php
$images = Post::getAllImages();
?>
<div class="slider-part">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img class="post-type-4" src="<? get_config('base_path') ?>assets/1.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img class="post-type-4" src="<? get_config('base_path') ?>assets/2.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img class="post-type-4" src="<? get_config('base_path') ?>assets/3.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img class="post-type-4" src="<? get_config('base_path') ?>assets/4.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img class="post-type-4" src="<? get_config('base_path') ?>assets/5.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img class="post-type-4" src="<? get_config('base_path') ?>assets/6.jpg" alt="">
            </div>
            <? if ($images) {
                foreach ($images as $i) {
            ?>
                    <div class="swiper-slide">
                        <img class="post-type-4" src="<? echo $i['image']; ?>" alt="">
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>