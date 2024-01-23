<main class="main">
    <div class="container">
        <section class="wrapper">
            <div class="heading">
                <h1 class="text text-large">Sign In</h1>
                <?
                if (Session::isAuthenticated()) {
                ?>
                    <h1 class="text text-large">Your Were Logged Already</h1>
                <?
                }
                ?>
                <!-- <p class="text text-normal">New user? <span><a href="/signup" class="text text-links">Create an account</a></span> -->
                <!-- </p> -->
            </div>
            <form id="signin-form" name="signin-form" class="form" method="post">
                <div class="input-control">
                    <label for="email" class="input-label" hidden>Email Address or Username</label>
                    <input type="" name="email" id="email" class="input-field" placeholder="Email Address or Username">
                </div>
                <div class="input-control">
                    <label for="password" class="input-label" hidden>Password</label>
                    <div class="icon-input-container">
                        <input type="password" name="password" id="password" class="input-field" placeholder="Password">
                        <img id="eye-icon" src="<?= get_config('base_path') ?>assets/view.png" class="icon" alt="View Password" srcset="">
                    </div>
                </div>
                <div class="input-control">
                    <a href="#" class="text text-links">Forgot Password</a>
                    <input type="submit" name="submit" class="input-submit" value="Sign In">
                </div>
            </form>
        </section>
    </div>
</main>