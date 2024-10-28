//______API______ 
// ADD POST
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
// UPDATE POST
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
// DELETE POST
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

// UPLOAD PDF
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
// DELETE PDF
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

// Add Category
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
// Delete Category
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

// Add Admin
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
// DELETE ADMIN
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

function clearImage() {
    $('#input-old-image').val('');
    $('#see-post-image-viewer').attr('src', '');
}

// Post Type Selection Info
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

let total_posts;
let currentOffset = 4;
let isLoadMore = true;

function loadmore(offset) {
    if (isLoadMore) {
        $.post("/api/get/card", { offset: offset }, function (data) {
            console.log(data);
            if (data.posts && data.posts.length > 0) {
                appendPosts(data.posts);
                currentOffset += data.posts.length;
            }
            if (currentOffset >= total_posts) {
                $('#loadmore-btn').text('Load Less');
                isLoadMore = false; // Switch to Load Less mode
            }
            showCustomToast(data.message);
        }).fail(function (xhr, status, error) {
            console.log(error);
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Please try again.';
            showCustomToast(errorMessage, true);
        });
    } else {
        removeLastPosts();
        if (currentOffset <= total_posts) {
            $('#loadmore-btn').text('Load More');
            isLoadMore = true; // Switch back to Load More mode
        }
    }
}

$('#loadmore-btn').on('click', function () {
    loadmore(currentOffset);
});

function countAllPost() {
    $.post("/api/post/count", function (data) {
        total_posts = data.counts;
    }).fail(function (xhr, status, error) {
        console.log(error);
        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Please try again.';
        showCustomToast(errorMessage, true);
    });
};
// countAllPost();

function removeLastPosts() {
    let postsToRemove = $('.recommend-card-grid .recommend-card').slice(-4);
    postsToRemove.remove();
    currentOffset -= 4;
    showCustomToast('Last set of posts removed');
}

function appendPosts(posts) {
    posts.forEach(function (post) {
        var postHtml = `
        <div class="recommend-card">
            <a href="/days/s/${post.title.replace(/\s+/g, '-')}">
                <img src="${post.image}" alt="">
            </a>
            <div class="rc_content rc_bottom">
                <a class="unset-inherit" href="/days/s/${post.title.replace(/\s+/g, '-')}">
                    <div class="rc_dec">
                        <h1>${post.title}</h1>
                        <p>${post.subtitle ? post.subtitle : 'No additional content available.'}</p>
                    </div>
                </a>
            </div>
            <div class="placement">
                <div class="heart-container" data-post-id="${post.id}">
                    <input class="rc-checkbox-${post.id}" type="checkbox" id="checkbox" />
                    <label for="checkbox">
                        <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                            <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#fff" />
                                <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5" />

                                <g id="grp7" opacity="0" transform="translate(7 6)">
                                    <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2" />
                                    <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2" />
                                </g>

                                <g id="grp6" opacity="0" transform="translate(0 28)">
                                    <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2" />
                                    <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2" />
                                </g>

                                <g id="grp3" opacity="0" transform="translate(52 28)">
                                    <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2" />
                                    <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2" />
                                </g>

                                <g id="grp2" opacity="0" transform="translate(44 6)">
                                    <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2" />
                                    <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2" />
                                </g>

                                <g id="grp5" opacity="0" transform="translate(14 50)">
                                    <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2" />
                                    <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2" />
                                </g>

                                <g id="grp4" opacity="0" transform="translate(35 50)">
                                    <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2" />
                                    <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2" />
                                </g>

                                <g id="grp1" opacity="0" transform="translate(24)">
                                    <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2" />
                                    <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2" />
                                </g>
                            </g>
                        </svg>
                    </label>
                    <span id="rc-likes-${post.id}">${post.likes}</span>
                </div>
            </div>
        </div>`;
        $('.recommend-card-grid').append(postHtml);
    });
}