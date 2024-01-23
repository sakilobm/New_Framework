<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<? get_config('base_path') ?>css/login.css">
</head>

<body>
    <? Session::loadTemplate('login/index') ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<? get_config('base_path') ?>js/login_signup.js"></script>
    <script>
        // Initialize the agent at application startup.
        const fpPromise = import('https://fpjscdn.net/v3/9JBGOVXwO60qCOMraL3C')
            .then(FingerprintJS => FingerprintJS.load({
                apiKey: '9JBGOVXwO60qCOMraL3C'
            }))
            .then(fp => {
                // Get the visitor identifier when you need it.
                return fp.get();
            })
            .then(result => {
                // This is the visitor identifier:
                // const visitorId = result.visitorId;
                // $('#fingerprint').val(visitorId);
                // console.log(visitorId);
                const visitorId = result.visitorId
                console.log("visitor :" + visitorId);
                // set a cookie 
                setCookie('fingerprint', visitorId, 1);
            })
            .catch(error => {
                console.error('Error loading or getting fingerprint:', error);
            });
    </script>
</body>

</html>