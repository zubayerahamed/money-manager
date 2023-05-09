/* ------------------------------------------------------------------------------
 *
 *  # Steps wizard
 *
 *  Demo JS code for form_wizard.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FormWizard = function() {


    //
    // Setup module components
    //

    // Wizard
    const _componentWizard = function() {
        if (!$().steps) {
            console.warn('Warning - steps.min.js is not loaded.');
            return;
        }

        // Basic wizard setup
        $('.steps-basic').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Previous' : '<i class="ph-arrow-circle-left me-2"></i> Previous',
                next: document.dir == 'rtl' ? 'Next <i class="ph-arrow-circle-left ms-2"></i>' : 'Next <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Submit form <i class="ph-paper-plane-tilt ms-2"></i>'
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentWizard();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormWizard.init();
});
