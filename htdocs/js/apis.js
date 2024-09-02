//______API______ 

//API (POST) - ADD POST
$('#addPost').submit(function (event) {
    event.preventDefault();
    $('#hiddenContent').val(quill.root.innerHTML);

    $.ajax({
        url: '/api/post/create',
        method: 'POST',
        data: new FormData($('#addPost')[0]),
        processData: false,
        contentType: false,
        success: function (response) {
            showCustomToast(response.message);
        },
        error: function (xhr, status, error) {
            console.log(error);
            var errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else {
                errorMessage = 'Post failed. Please try again.';
            }
            showCustomToast(errorMessage, true);
        }
    });
});
//API - UPDATE POST
$('#updatePost').submit(function (event) {
    event.preventDefault();
    $('#hiddenContent').val(quill.root.innerHTML);

    $.ajax({
        url: '/api/post/update',
        method: 'POST',
        data: new FormData($('#updatePost')[0]),
        processData: false,
        contentType: false,
        success: function (response) {
            console.log("Success For Post Updating...");
            showCustomToast("Post Has Been Updated");
        },
        error: function (xhr, status, error) {
            console.log("Failed For Post Updating..." + status);
            var errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else {
                errorMessage = 'Please try again.';
            }
            showCustomToast(errorMessage, true);
        }
    });
});
//API - UPLOAD PDF
$('#formOfSendPdf').submit(function (event) {
    event.preventDefault();

    $.ajax({
        url: '/api/pdf/add',
        method: 'POST',
        data: new FormData($('#formOfSendPdf')[0]),
        processData: false,
        contentType: false,
        success: function (response) {
            console.log("Success For Post Updating...");
            showCustomToast("Pdf Has Been Updated To The Post");
        },
        error: function (xhr, status, error) {
            console.log("Failed For Post Updating..." + status);
            var errorMessage = '';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else {
                errorMessage = 'Please try again.';
            }
            showCustomToast(errorMessage, true);
        }
    });
});
//API - DELETE PDF
function deletePdf(postId) {
    if (confirm("Are You Sure Want To Delete This Post's Pdf ?")) {

        $.post("/api/pdf/delete", { id: postId }, function (data) {
            console.log("Successdfully post's pdf deleted...");
            setTimeout(function () {
                showCustomToast(data.message);
            }, 1000)
            setTimeout(function () {
                location.reload();
            }, 4000);
        }).fail(function (xhr, status, error) {
            console.log("Failed For Post Deleting..." + error);
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
    }
}
//API - DELETE POST
function deletePost(postId) {
    if (confirm('Delete this post?')) {
        $.post("/api/post/delete", { id: postId }, function (data) {
            console.log("Successdfully post deleted...");
            $('.post-' + postId).remove();
            showCustomToast("Post has been removed");

        }).fail(function (xhr, status, error) {
            console.log("Failed For Post Deleting..." + error);
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
    }
}


//API (CATEGORY) - Add Category
$('#addCategory').submit(function (event) {
    // Prevent the default form submission
    event.preventDefault();
    // Perform an AJAX (Asynchronous JavaScript and XML) request
    $.post("/api/category/create", $(this).serialize(), function (data) {
        console.log("Successdfully New Category Added...");
        showCustomToast("New Category Added");
        setTimeout(function () {
            location.reload();
        }, 2000);
    }).fail(function (xhr, status, error) {
        console.log("Failed For Category Add..." + error);
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
//API - Delete Category
function deleteCatgory(categoryId, category) {
    var confirmation = confirm('⚠️ Warning: Deleting this (' + category + ') category will also delete all associated posts. Are you sure you want to proceed? ⚠️ ');
    if (!confirmation) {
        return;
    }
    $.post("/api/category/delete", JSON.stringify({ id: categoryId }), function (data) {
        console.log("Successfully Category Deleted...");
        $('.category-' + categoryId).remove();
        showCustomToast("Category Deleted Successfully");
        setTimeout(function () {
            location.reload();
        }, 2000);
    }).fail(function (xhr, status, error) {
        console.log("Failed to delete category: " + error);
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
};

//API (ADMIN) - Add Admin
$('#signup-form').submit(function (event) {
    event.preventDefault();
    var form = $(this);
    $.post("/api/auth/signup", $(this).serialize(), function (data) {
        form[0].reset();
        console.log(data);
        showCustomToast("New Admin Added");
        setTimeout(function () {
            location.reload();
        }, 1000);
    }).fail(function (xhr, status, error) {
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
// API -DELETE ADMIN
function deleteAdmin(admin_id, admin_name, current_user) {
    let confirmMessage = 'Are you sure you want to delete this admin ' + admin_name + '?';
    let sameUser = false;

    if (admin_name === current_user) {
        sameUser = true;
        confirmMessage = 'Are you sure you want to delete your account ' + admin_name + '?';
    }

    if (confirm(confirmMessage)) {
        var fromData = {
            admin_id: admin_id,
            same_user: sameUser
        }

        $.ajax({
            url: '/api/admin/delete',
            method: 'POST',
            data: JSON.stringify(fromData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                console.log("admin Has Been Deleted");
                $('.admin-' + admin_id).remove();
                showCustomToast("Admin Has Been Removed");
                setTimeout(function () {
                    location.reload();
                }, 1000)
            },
            error: function (xhr, status, error) {
                console.log("Failed For Admin Deleting..." + error);
                var errorMessage = '';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else {
                    errorMessage = 'Please try again.';
                }
                showCustomToast(errorMessage, true);
            }
        });
    }
}