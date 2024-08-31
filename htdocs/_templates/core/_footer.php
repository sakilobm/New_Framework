<footer>
    <br>
    <hr>
    <br>
    <div class="footer-content" style="margin-top: 12px;">
        <div class="footer-list">
            <?php
            $categories = Category::getAllCategory();
            foreach ($categories as $cate) {
            ?>
                <a style="text-decoration: none; color: #ffffffb2;" href="#">
                    <li class=""><?= $cate['list_category'] ?></li>
                </a>
            <? } ?>
        </div>
        <div class="footer-list">
            <?php
            $categories = Category::getAllCategory();
            foreach ($categories as $cate) {
            ?>
                <a style="text-decoration: none; color: #ffffffb2;" href="#">
                    <li class=""><?= $cate['list_category'] ?></li>
                </a>
            <? } ?>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12 text-center">
                <p class="copyright-text">Copyright &copy; 2023 All Rights Reserved by
                    <a href="#">Reviewernews</a>.
                </p>
            </div>
            <!-- <div class="col-md-4 col-sm-6 col-xs-12">
                <ul class="social-icons">
                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div> -->
        </div>
    </div>
    <br>
</footer>