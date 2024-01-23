<main class="main">
    <div class="container">
        <section class="wrapper">
            <div class="heading">
                <h1 class="text text-large">Sign In</h1>
                <p class="text text-normal">New user? <span><a href="#" class="text text-links">Create an account</a></span>
                </p>
            </div>
            <form id="signup-form" name="signup" class="form" method="post">
                <input type="hidden" name="fingerprint" value="">
                <div class="input-control">
                    <label for="username" class="input-label" hidden>Username</label>
                    <input type="username" name="username" id="username" class="input-field" placeholder="Username">
                </div>
                <div class="input-control">
                    <label for="password" class="input-label" hidden>Password</label>
                    <input type="password" name="password" id="password" class="input-field" placeholder="Password">
                </div>
                <div class="input-control">
                    <label for="email" class="input-label" hidden>Email Address</label>
                    <input type="email" name="email" id="email" class="input-field" placeholder="Email Address">
                </div>
                <div class="input-control">
                    <label for="phone" class="input-label" hidden>Phone Number</label>
                    <input type="number" min="10" name="phone" id="phone" class="input-field" placeholder="Phone Number">
                </div>
                <div class="input-control">
                    <a href="/login" class="text text-links">I already have an account</a>
                    <input type="submit" name="submit" class="input-submit" value="Sign Up">
                </div>
            </form>
        </section>
    </div>
</main>