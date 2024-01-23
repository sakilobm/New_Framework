$(document).ready(function () {
    $().ready(function () {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function (event) {
            if ($(this).hasClass('switch-trigger')) {
                if (event.stopPropagation) {
                    event.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
            }
        });

        $('.fixed-plugin .background-color span').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('color');

            if ($sidebar.length != 0) {
                $sidebar.attr('data', new_color);
            }

            if ($main_panel.length != 0) {
                $main_panel.attr('data', new_color);
            }

            if ($full_page.length != 0) {
                $full_page.attr('filter-color', new_color);
            }

            if ($sidebar_responsive.length != 0) {
                $sidebar_responsive.attr('data', new_color);
            }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function () {
            var $btn = $(this);

            if (sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                sidebar_mini_active = false;
                blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
            } else {
                $('body').addClass('sidebar-mini');
                sidebar_mini_active = true;
                blackDashboard.showSidebarMessage('Sidebar mini activated...');
            }

            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function () {
                window.dispatchEvent(new Event('resize'));
            }, 180);

            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function () {
                clearInterval(simulateWindowResize);
            }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function () {
            var $btn = $(this);

            if (white_color == true) {

                $('body').addClass('change-background');
                setTimeout(function () {
                    $('body').removeClass('change-background');
                    $('body').removeClass('white-content');
                }, 900);
                white_color = false;
            } else {

                $('body').addClass('change-background');
                setTimeout(function () {
                    $('body').removeClass('change-background');
                    $('body').addClass('white-content');
                }, 900);

                white_color = true;
            }


        });

        $('.light-badge').click(function () {
            $('body').addClass('white-content');
        });

        $('.dark-badge').click(function () {
            $('body').removeClass('white-content');
        });
    });
});

$(document).ready(function () {
    // Javascript method's body can be found in assets_admin/js/demos.js
    demo.initDashboardPageCharts();

});

window.TrackJS &&
    TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
    });

// Function to show custom toast
function showCustomToast(message, isError = false) {
    var customToast = $('#customToast');
    customToast.text(message);

    // Set different styles for error and success toasts
    if (isError) {
        customToast.css('background-color', '--red');
    } else {
        customToast.css('background-color', '#7B66FF');
    }

    // Show and hide the toast
    customToast.addClass('show');
    setTimeout(function () {
        customToast.removeClass('show');
    }, 3000); // Adjust the duration as needed
}

//______API______ 

// ADD POST
$('#addPost').submit(function (event) {
    // Prevent the default form submission
    event.preventDefault();
    $.ajax({
        url: '/api/post/create', // Specify the URL to submit the form data
        method: 'POST', // Use the POST method
        data: new FormData($('#addPost')[0]), // Serialize the form data
        processData: false,
        contentType: false,
        success: function (response) {
            showCustomToast("New Post Added", true);
        },
        error: function (xhr, status, error) {
            var errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else {
                errorMessage = 'Image upload failed. Please try again.';
            }
            showCustomToast(errorMessage, true);
        }
    });
});
// UPDATE POST
$('#updatePost').submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: '/api/post/update',
        method: 'POST',
        data: new FormData($('#updatePost')[0]), // Send the post ID as data
        processData: false,
        contentType: false,
        success: function (response) {
            console.log("Success For Post Updating...");
            showCustomToast("Post Has Been Updated", true);
        },
        error: function (xhr, status, error) {
            console.log("Failed For Post Updating..." + status);
            var errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else {
                errorMessage = 'Please try again.';
            }
            showCustomToast(errorMessage, true);
        }
    });
});
// DELETE POST
function deletePost(postId) {
    if (confirm('Delete this post?')) {
        // Perform an AJAX request\
        $.post("/api/post/delete", { id: postId }, function (data) {
            console.log("Successdfully post deleted...");
            // Remove the post element from the DOM
            $('.post-' + postId).remove();
            showCustomToast("Post has been removed", true);

        }).fail(function (xhr, status, error) {
            console.log("Failed For Post Deleting..." + error);
            var errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else {
                errorMessage = 'Please try again.';
            }
            showCustomToast(errorMessage, true);
        });
    }
}

function clearImage() {
    $('#input-old-image').val('');
    $('#see-post-image-viewer').attr('src', '');
}

// CATEGORY APIS
// Add Category
$('#addCategory').submit(function (event) {
    // Prevent the default form submission
    event.preventDefault();
    // Perform an AJAX (Asynchronous JavaScript and XML) request
    $.post("/api/category/create", $(this).serialize(), function (data) {
        console.log("Successdfully New Category Added...");
        showCustomToast("New Category Added", true);
        setTimeout(function () {
            location.reload();
        }, 2000);
    }).fail(function (xhr, status, error) {
        console.log("Failed For Category Add..." + error);
        var errorMessage = '';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        } else {
            errorMessage = 'Please try again.';
        }
        showCustomToast(errorMessage, true);
    });
});
// Delete Category
function deleteCatgory(categoryId, category) {
    event.preventDefault();
    var confirmation = confirm('⚠️ Warning: Deleting this (' + category + ') category will also delete all associated posts. Are you sure you want to proceed? ⚠️ ');
    if (!confirmation) {
        event.preventDefault(); // Prevent form submission if the user cancels
        return;
    }
    $.post("/api/category/delete", JSON.stringify({ id: categoryId }), function (data) {
        console.log("Successfully Category Deleted...");
        $('.category-' + categoryId).remove();
        showCustomToast("Category Deleted Successfully", true);
        setTimeout(function () {
            location.reload();
        }, 2000);
    }).fail(function (xhr, status, error) {
        console.log("Failed to delete category: " + error);
        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Please try again.';
        showCustomToast(errorMessage, true);
    });
};

// ADMIN
// Add Admin
$('#signup-form').submit(function (event) {
    event.preventDefault(); // Prevent the default form submission
    var form = $(this);
    $.post("/api/auth/signup", $(this).serialize(), function (data) {
        form[0].reset();
        console.log(data);
        showCustomToast("New Admin Added", true);
        setTimeout(function () {
            location.reload();
        }, 2000);
    }).fail(function (xhr, status, error) {
        console.error("Error:", error);
        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Please try again.';
        showCustomToast(errorMessage, true);
    });
});

// DELETE ADMIN
function deleteAdmin(admin_id, admin_name) {
    if (confirm('Are You Sure You Want To Delete This Admin ' + admin_name + ' ? ')) {
        var fromData = {
            admin_id: admin_id,
        }
        event.preventDefault();
        $.ajax({
            url: '/api/admin/delete',
            method: 'POST',
            data: JSON.stringify(fromData), // Send the post ID as data
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                console.log("admin Has Been Deleted");
                // Remove the post element from the DOM
                $('.admin-' + admin_id).remove();
                showCustomToast("Admin Has Been Removed", true);
            },
            error: function (xhr, status, error) {
                console.log("Failed For Admin Deleting..." + error);
                var errorMessage = '';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else {
                    errorMessage = 'Please try again.';
                }
                showCustomToast(errorMessage, true);
            }
        });
    }
}


// Post Type Selection Info
$(document).ready(function () {
    $('#postTypeSelect').change(function () {
        var selectedType = $(this).val();
        var postTypeInfo = '';

        if (selectedType === 'Type 1') {
            postTypeInfo = 'Type 1: Font color is white ⚪ (Image Background Should Black⚫)';
        } else if (selectedType === 'Type 2') {
            postTypeInfo = 'Type 2: Font color is black ⚫ (Image Background Should White⚪)';
        } else if (selectedType === 'Type 3 A') {
            postTypeInfo = 'Type 3: Font color is white ⚪, Square post (Image Background Should Black⚫)';
        } else if (selectedType === 'Type 3 B') {
            postTypeInfo = 'Type 3: Font color is black ⚫, Square post (Image Background Should White⚪)';
        }

        $('.post-type').text(postTypeInfo);
    });
});
