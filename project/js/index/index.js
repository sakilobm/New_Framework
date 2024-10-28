// Step 1 - Start CountDown To Show 'Scroll Down'
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}
console.log('auth_code: ' + authCode + ' alias ' + alias);

var authCode = getUrlParameter('auth_code');
var alias = getUrlParameter('alias');

if (authCode || alias) {
    console.log('Starting countdown');
    startScrollDownCount(25);
} else {
    console.log('auth_code or alias not found in URL.');
}

function startScrollDownCount(countdown = 25) {
    var countdownElement = $("#scroll-down-countdown");
    var scrollDownImg = $("#scroll-down-img");

    var interval = setInterval(function () {
        if (countdown > 0) {
            countdownElement.text("Please wait " + countdown + " seconds...");
            countdown--;
        } else {
            clearInterval(interval);
            countdownElement.text("Scroll Down &#8595; and click continue ");
            scrollDownImg.show();
        }
    }, 1000);

}

// Step 2 - After 'Scroll Down' Show Button
var button = document.getElementById("countdown-button-continue");

function startCountdown() {
    var getRedirectUrl = document.getElementById("get-redirect-url");
    var countdown = 5;

    function updateCountdown() {
        if (countdown === 0) {
            button.innerHTML = "Click Here"; // Change the button text
            button.href = getRedirectUrl.value;
            button.removeAttribute("disabled");
        } else {
            button.innerHTML = "Continue in " + countdown + "s"; // Update the button text
            button.setAttribute("disabled", "disabled"); // Disable the button
            countdown--;
            setTimeout(updateCountdown, 1000); // Update the countdown every second
        }
    }

    updateCountdown();
    button.removeEventListener("click", startCountdown); // Remove the click event listener
}
if (button) {
    button.addEventListener("click", startCountdown);
}
