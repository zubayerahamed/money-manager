/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */
var kit = kit || {};
kit.ui = kit.ui || {};
kit.ui.config = kit.ui.config || {};

function datepickerInit(){
	$.each($('.datepicker-date-format'), function(ind, elem){
		var maxDate = undefined;
		var minDate = undefined;

		if($(elem).attr('maxDate')){
			maxDate = $(elem).attr('maxDate')
		}

		if($(elem).attr('minDate')){
			minDate = $(elem).attr('minDate')
		}

		new Datepicker(elem, {
			container: '.content-inner',
			buttonClass: 'btn btn-sm',
			prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
			nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
			format: 'yyyy-mm-dd',
			maxDate: maxDate,
			minDate: minDate
		});

	});
}

function dateAndTimepickerInit(){

	$.each($('.timepicker'), function(ind, elem){
		$(elem).datetimepicker({
			format: "HH:mm",   // LT, LTS
			icons: {
				up: "ph-caret-up",
				down: "ph-caret-down"
			}
		});
	});

	$.each($('.datetimepicker'), function(ind, elem){
		$(elem).datetimepicker({
			useCurrent: false,
			format: "ddd, DD-MMM-YYYY HH:mm:ss",  // L, LL
			showTodayButton: true,
			icons: {
				next: "fa fa-chevron-right",
				previous: "fa fa-chevron-left",
				today: 'todayText',
				up: "fa fa-chevron-up",
				down: "fa fa-chevron-down"
			}
		});
	});
}


kit.ui.config.loadPageData = function(){

    loadingMask2.show();

    var definedRoute = $('#sections-reloader').data('defined-route');
    
    var url = $('#sections-reloader').val();
    if(definedRoute != undefined){
        url = url + '?definedRoute=' + definedRoute;
    }

    $.ajax({
        url: url,
        type: "GET",
        success: function (data) {
            loadingMask2.hide();
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

// Override Noty defaults
Noty.overrideDefaults({
    theme: 'kit',
    layout: 'topRight',
    type: 'alert',
    timeout: 2500
});

// Toaster message
function showMessage(type, message) {
    if (type == undefined || type == "") return;

    new Noty({
        text: message,
        type: type
    }).show();
}

/**
 * Icon modal
 */
function openIconModal() {
    $('#icon-modal').modal('show');
}

/**
 * Reload section with ajax request
 */
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

/**
 * Sumbit form 
 */
function submitForm(formEl, method, transactionData) {

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

            if(data.inmodal == true){
                $('.transaction-modal-title').html(data.modaltitle);
                modalWidget(data.url, 'transaction');
                return;
            }

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

            if(transactionData){
                kit.ui.config.loadPageData();
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            showMessage("error", jqXHR.responseJSON.message);
        },
    });
}

/**
 * Open sections in modal
 */
function modalWidget(url, elementClass) {
    loadingMask2.show();
    $.ajax({
        url: url,
        type: "GET",
        success: function (data) {
            loadingMask2.hide();
            $("." + elementClass + "-form-wrapper").html("");
            $('#' + elementClass + '-modal').modal('show');
            $("." + elementClass + "-form-wrapper").append(data);

            datepickerInit();
            dateAndTimepickerInit();
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            showMessage("error", jqXHR.responseJSON.message);
        },
    });
}

/**
 * Load functions and init events when document is loaded
 */
$(document).ready(function () {
    datepickerInit();
    dateAndTimepickerInit();

    $('body').on('click', '.transaction-btn', function (e) {
        e.preventDefault();

        var url = $(this).attr("href");
        var modalTitle = $(this).data('title');

        $('.transaction-modal-title').html(modalTitle);

        modalWidget(url, 'transaction');
    });

    $('body').on('click', '.transaction-submit-btn', function (e) {
        e.preventDefault();

        var transactionData = $('input[name="transaction_type"]').val() != undefined;

        submitForm($('#transaction-form'), 'POST', transactionData);
    });

    //Initialize Select2 Elements
    $(document).on("select2:open", () => {
        document.querySelector(".select2-search__field").focus();
    });
    
    if ($(".select2").length > 0) {
        $(".select2").select2();
    }

});
