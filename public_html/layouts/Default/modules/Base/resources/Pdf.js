/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

$.Class(
  'Base_Pdf_Js',
  {},
  {
    /**
     * Function to register the click event for generate button
     * @param {jQuery} container
     */
    registerSubmitEvent: function(container) {
      container.find('#generatePdf').on('click', function(e) {
        const templateIds = [];
        container.find('[type="checkbox"].js-template').each(function() {
          if ($(this).is(':checked')) {
            templateIds.push($(this).val());
          }
        });
        container.find('[name="templates"]').val(JSON.stringify(templateIds));
      });
    },
    /**
     * Validate submit button
     * @param   {jQuery}  container
     */
    validateSubmit: function(container) {
      let disabled = true;
      container.find('[type="checkbox"].js-template').each(function() {
        if ($(this).prop('checked')) {
          disabled = false;
          return false;
        }
      });
      container.find('#generatePdf').attr('disabled', disabled);
    },
    /**
     * Register validate submit
     * @param   {jQuery}  container
     */
    registerValidateSubmit(container) {
      this.validateSubmit(container);
      container.find('[type="checkbox"].js-template').on('change', () => {
        this.validateSubmit(container);
      });
    },
    /**
     * Register all events in view
     * @param {jQuery} container
     */
    registerEvents: function(container) {
      this.registerSubmitEvent(container);
      this.registerValidateSubmit(container);
    }
  }
);
