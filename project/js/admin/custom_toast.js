//______TOAST______ 

// Function to show custom toast
/**
 * Displays a toast message with custom background color based on error state.
 * 
 * @param {string} message - Enter a toast message to display.
 * @param {boolean} isError - Set to true to display an error toast, false for a normal toast.
 */
function showCustomToast(message, isError = false) {
    var customToast = $('#customToast');
    customToast.text(message);

    // Set different styles for error and success toasts
    if (isError) {
        customToast.css('background-color', '#851d41');
    } else {
        customToast.css('background-color', '#03a65a');
    }

    // Show and hide the toast
    customToast.addClass('show');
    setTimeout(function () {
        customToast.removeClass('show');
    }, 3000); // Adjust the duration as needed
}