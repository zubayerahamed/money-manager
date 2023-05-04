/**
 * Loading mask object
 * function1 : show  -- Show loading mask
 * function2 : hide  -- Hide loading mask
 */
var loadingMask2 = {
    show: function () {
        $("div#loadingmask2, div.loadingdots, div#loadingdots").removeClass(
            "nodisplay"
        );
    },
    hide: function () {
        $("div#loadingmask2, div.loadingdots, div#loadingdots").addClass(
            "nodisplay"
        );
    },
};


// Toaster message
function showMessage(type, message) {
    if (type == undefined || type == "") return;

    var className = "";
    if (type.toUpperCase() == "SUCCESS") {
        className = "success";
    } else if (type.toUpperCase() == "ERROR") {
        className = "danger";
    } else if (type.toUpperCase() == "INFO") {
        className = "info";
    } else if (type.toUpperCase() == "WARNING") {
        className = "warning";
    }

    if (className == "") return;

    $('.toast-msg-wrapper').removeClass('d-none');
    $('.toast-msg').addClass('alert-' + className);
    $('.toast-msg-status').html(type.toUpperCase() + " ! ");
    $('.toast-msg-body').html(message);

    setTimeout(() => {
        $('.toast-msg-wrapper').addClass('d-none');
        $('.toast-msg').removeClass('alert-' + className);
        $('.toast-msg-status').html("");
        $('.toast-msg-body').html("");
    }, 5000);
}

function openIconModal() {
    $('#icon-modal').modal('show');
}

function sectionReloadAjaxReq(section) {
    loadingMask2.show();
    $.ajax({
        url: section[1],
        type: "GET",
        success: function (data) {
            loadingMask2.hide();
            $("." + section[0]).html("");
            $("." + section[0]).append(data);
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            showMessage("error", jqXHR.responseJSON.message);
        },
    });
}

// Delete button event from parent body
function deleteData(el) {
    var formId = $(el).data("form-id");
    if (
        confirm(
            "Are you sure you want to delete this item? This is a permanent action and cannot be undone."
        )
    ) {
        submitForm($("#" + formId), 'DELETE');
    }
}


function submitForm(formEl, method) {

    var url = $(formEl).attr('action');
    var data = $(formEl).serializeArray();

    loadingMask2.show();
    $.ajax({
        url: url,
        type: method,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
        },
        data: data,
        success: function (data) {
            loadingMask2.hide();
            showMessage(data.status, data.message, data.reload);
            if (data.status == 'success') {
                $(".transaction-form-wrapper").html("");
                $('#transaction-modal').modal('hide');
            }
            if (data.reload == true) {
                if (data.sections.length > 0) {
                    $.each(data.sections, function (ind, section) {
                        sectionReloadAjaxReq(section);
                    });
                } else {
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            showMessage("error", jqXHR.responseJSON.message);
        },
    });
}


$(document).ready(function () {

    $('body').on('click', '.transaction-btn', function (e) {
        e.preventDefault();

        var url = $(this).attr("href");
        var modalTitle = $(this).data('title');
        $('.transaction-modal-title').html(modalTitle);

        loadingMask2.show();
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                loadingMask2.hide();
                $(".transaction-form-wrapper").html("");
                $('#transaction-modal').modal('show');
                $(".transaction-form-wrapper").append(data);
            },
            error: function (jqXHR, status, errorThrown) {
                loadingMask2.hide();
                showMessage("error", jqXHR.responseJSON.message);
            },
        });
    });

    $('body').on('click', '.transaction-submit-btn', function (e) {
        e.preventDefault();
        submitForm($('#transaction-form'), 'POST');
    });
})
