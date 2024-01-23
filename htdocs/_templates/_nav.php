<div>
    <nav>
        <ul id="nav-list">
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ubuntu" viewBox="0 0 16 16">
                    <path d="M2.273 9.53a2.273 2.273 0 1 0 0-4.546 2.273 2.273 0 0 0 0 4.547Zm9.467-4.984a2.273 2.273 0 1 0 0-4.546 2.273 2.273 0 0 0 0 4.546M7.4 13.108a5.54 5.54 0 0 1-3.775-2.88 3.27 3.27 0 0 1-1.944.24 7.4 7.4 0 0 0 5.328 4.465c.53.113 1.072.169 1.614.166a3.25 3.25 0 0 1-.666-1.9 6 6 0 0 1-.557-.091m3.828 2.285a2.273 2.273 0 1 0 0-4.546 2.273 2.273 0 0 0 0 4.546m3.163-3.108a7.44 7.44 0 0 0 .373-8.726 3.3 3.3 0 0 1-1.278 1.498 5.57 5.57 0 0 1-.183 5.535 3.26 3.26 0 0 1 1.088 1.693M2.098 3.998a3.3 3.3 0 0 1 1.897.486 5.54 5.54 0 0 1 4.464-2.388c.037-.67.277-1.313.69-1.843a7.47 7.47 0 0 0-7.051 3.745" />
                </svg>

                <a style="text-decoration: none; color: #ffffffb2;" href="#">
            <li class="hidemobile"></li>
            </a>
            <?
            $categories = Category::getAllCategory();
            foreach ($categories as $cate) {
            ?>
                <a style="text-decoration: none; color: #ffffffb2;" href="/cateI/<?= $cate['id'] ?>">
                    <li class="hidemobile"><?= ucwords($cate['list_category']) ?></li>
                </a>
            <? }
            if (Session::isAuthenticated()) {
            ?>

                <a style="text-decoration: none; color: #ffffffb2;" href="/?logout">
                    <li class="hidemobile">Logout</li>
                </a>

            <?
            } ?>
            <li class="search-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z">
                    </path>
                </svg>
            </li>
            <!-- <li> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
            </svg> </li> -->

            <li class="mobile-only">
                <button style="background-color: rgba(22, 22, 23, 0.982); color:aliceblue ; border:none;" type="button" onclick="showAndHideSidebar();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                    </svg>
                </button>
            </li>
            </li>
        </ul>
    </nav>
    <div id="sidebar" class="sidebar">
        <ul>
            <?php
            $categories = Category::getAllCategory();
            foreach ($categories as $cate) {
            ?>
                <a style="text-decoration: none; color: #ffffffb2;" href="/cateI/<?= $cate['id'] ?>">
                    <li class="showmobile"><?= ucwords($cate['list_category']) ?></li>
                </a>
            <? } ?>
            <? if (Session::isAuthenticated()) {
            ?>
                <a style="text-decoration: none; color: #ffffffb2;" href="/?logout">
                    <li class="showmobile">Logout</li>
                </a>
            <?
            } ?>
        </ul>
    </div>
</div>