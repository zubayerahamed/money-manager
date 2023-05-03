/**
         * Loading mask object
         * function1 : show  -- Show loading mask
         * function2 : hide  -- Hide loading mask
         */
var loadingMask2 = {
    show: function() {
        $("div#loadingmask2, div.loadingdots, div#loadingdots").removeClass(
            "nodisplay"
        );
    },
    hide: function() {
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