$('#signup-form').submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    $.post("/api/auth/signup", $(this).serialize(), function (data) {
        // Handle the response from the server
        console.log(data);
        location.href = "/login";
        // You can add further logic here based on the response

    }).fail(function (xhr, status, error) {
        // Handle the error
        console.error("Error:", error);
        var errorMessage = '';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        } else if (xhr.responseJSON && xhr.responseJSON.error) {
            errorMessage = xhr.responseJSON.error;
        } else {
            errorMessage = 'Please try again.';
        }
        showCustomToast(errorMessage, true);
    });
});
$('#signin-form').submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    $.post("/api/auth/login", $(this).serialize(), function (data) {
        // Handle the response from the server
        console.log(data);
        location.href = "/admin";
        // You can add further logic here based on the response

    }).fail(function (xhr, status, error) {
        // Handle the error
        console.error("Error:", error);
        var errorMessage = '';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        } else if (xhr.responseJSON && xhr.responseJSON.error) {
            errorMessage = xhr.responseJSON.error;
        } else {
            errorMessage = 'Please try again.';
        }
        showCustomToast(errorMessage, true);
    });
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

$('#eye-icon').click(function () {
    if ($('#password').attr('type') == 'password') {
        $('#password').get(0).type = 'text';
    } else {
        $('#password').get(0).type = 'password';
    }
})