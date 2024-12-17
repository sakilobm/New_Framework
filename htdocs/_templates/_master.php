<!DOCTYPE html>
<html lang="en">

<head>
    <? Session::loadTemplate('core/_head') ?>
</head>

<body>

    <section id="home" class="home">
        <div class="circles">
            <div class="left-side-circle">
                <img src="<? get_config('base_path') ?>/assets/svg/Leftside_Controler_Menu.svg" alt="PlayButton">
            </div>
            <div class="center-side-circle">
                <img src="<? get_config('base_path') ?>/assets/svg/Centerside_Controler_Menu.svg" alt="PlayButtn">
            </div>
            <div class="right-side-circle">
                <img src="<? get_config('base_path') ?>/assets/svg/Rightside_Controler_Menu.svg" alt="PlayButton">
            </div>
        </div>
        <div class="profile">
            <h1>Hello<span>.</span></h1>
            <div class="name-line">
                <div class="underline"></div>
                <p class="name">I'm <span>Sakil</span></p>
            </div>
            <p class="description">App and Web Developer<br>Designer</p>
        </div>
        <div class="menu">
            <p class="option">Ui</p>
            <p class="option">App</p>
            <p class="option">Web</p>
            <p class="option">Animation</p>
            <p class="option">3d</p>
        </div>
        <div class="play-button">
            <img src="<? get_config('base_path') ?>/assets/svg/play_button.svg" alt="PlayButton">
            <p class="option">Play</p>
        </div>
        <div class="top-dots">
            <img src="<? get_config('base_path') ?>/assets/svg/top_dots.svg" alt="TopDots">
        </div>
        <div class="bottom-dots">
            <img src="<? get_config('base_path') ?>/assets/svg/bottom_dots.svg" alt="BottomDots">
        </div>
    </section>

    <!-- <div id="work" class="screen">
        <div class="work-header">
            <h1>Work.</h1>
            <p>Creativity fuels itself. The more you give, the more it grows within.</p>
        </div>
        <div class="work-grid">
            <div class="grid-item">4</div>
            <div class="grid-item">5</div>
            <div class="grid-item">6</div>
        </div>
    </div> -->

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="nav-links">
            <a href="#tutorials" class="nav-item">Tutorials</a>
            <a href="#hello" class="nav-item active">
                Hello
                <div class="underline"></div>
            </a>
            <a href="#work" class="nav-item">Work</a>
        </div>
        <div class="social-links">
            <a href="#" class="social-icon">
                <img src="<? get_config('base_path') ?>/assets/images/YouTube.png" alt="YouTube">
            </a>
            <a href="#" class="social-icon">
                <img src="<? get_config('base_path') ?>/assets/images/Facebook.png" alt="Facebook">
            </a>
            <a href="#" class="social-icon">
                <img src="<? get_config('base_path') ?>/assets/images/Instagram.png" alt="Instagram">
            </a>
            <a href="#" class="social-icon">
                <img src="<? get_config('base_path') ?>/assets/images/Twitter.png" alt="Twitter">
            </a>
        </div>
    </nav>

    <!-- Js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<? get_config('base_path') ?>/assets/js/index.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Create the custom cursor element
            const ball = document.createElement('div');
            ball.className = 'ball';
            document.body.appendChild(ball);

            // Update the position of the custom cursor on mouse move
            document.addEventListener('mousemove', (e) => {
                const x = e.clientX;
                const y = e.clientY;

                // Move the custom cursor to follow the mouse position
                ball.style.left = `${x}px`;
                ball.style.top = `${y}px`;
            });
        });
    </script>
</body>

</html>