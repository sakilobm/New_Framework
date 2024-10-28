/**
 * This function creates and displays a dynamic toast message.
 * @param {*} type Toast Type Should Be (e.g., 'success', 'error', 'warning', 'help').
 * @param {*} title Title of the toast message.
 * @param {*} message Content of the toast message.
 * @example - showToast('success', 'Title Here', 'Content Here');
 */

function showToast(type, title, message) {
    var lowerCaseType = type.toLowerCase();
    var toastPanel = $('.toast-panel');

    var newToast = $('<div class="toast-item"></div>');
    newToast.addClass(lowerCaseType);

    var subToast = $('<div class="toast ' + lowerCaseType + '"></div>');
    subToast.append('<label for="t-' + lowerCaseType + '" class="close"></label>');
    subToast.append('<h3>' + title + '</h3>');
    subToast.append('<p>' + message + '</p>');

    newToast.append(subToast);

    toastPanel.append(newToast);

    newToast.find('.close').click(function (e) {
        e.preventDefault();
        newToast.fadeOut("slow", function () {
            $(this).remove();
        });
    });
    setTimeout(() => {
        newToast.fadeOut("slow", function () {
            $(this).remove();
        });
    }, 3000);
}