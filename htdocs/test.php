<?php
include_once 'libs/load.php';

// $id = 84;
// $p = new Post($id);
// $image = $p->getImage();
// $image_name = basename($image);
// echo ":Image Name " . $image_name;
// echo ":Loading..";
// $result = Post::deletePostWithImage($id);

// if ($result) {
//     echo "Success..";
// } else {
//     echo "Try Again..";
// }

$posts = Post::getAllType3Posts();
if ($posts) {
    foreach ($posts as $p) {
        $title = $p['title'];
        $content = $p['content'];
        $image = $p['image'];
        echo $title;
        echo $content;
        echo $image;

?>
        <div class="part-4">
            <div class="part-1 part-4-1">
                <img src="<? get_config('base_path') ?>assets/4-1.jpg" alt="" />
                <div class="text-part-1 text-part-3">
                    <img src="<? get_config('base_path') ?>assets/4-1-1.png" alt="" />
                    <p>Titanium. So Strong. So Light. So Pro</p>
                    <div class="link">
                        <a href="">Learn More ></a>
                        <a href="">Buy ></a>
                    </div>
                </div>
            </div>
            <div class="part-1 part-4-2">
                <img src="<? get_config('base_path') ?>assets/4-2.jpg" alt="" />
                <div class="text-part-1 text-part-3">
                    <img src="<? get_config('base_path') ?>assets/4-2-1.png" alt="" />
                    <p>Titanium. So Strong. So Light. So Pro</p>
                    <div class="link">
                        <a href="">Learn More ></a>
                        <a href="">Buy ></a>
                    </div>
                </div>
            </div>
        </div>
<?
    }
}
