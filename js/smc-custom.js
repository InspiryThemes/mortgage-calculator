(function ($) {

    'use strict';

    function numberFormat(val, decimalPlaces) {

        var multiplier = Math.pow(10, decimalPlaces);
        return (Math.round(val * multiplier) / multiplier).toFixed(decimalPlaces);
    }

    function smcFuncOutput(){

        var smcfTaVal = $("#smcf-total-amount").val(),
            smcfDpVal = $("#smcf-down-payment").val(),
            smcfIrVal = $("#smcf-interest-rate").val(),
            smcfApVal = $("#smcf-amortization-period").val();

        var i = smcfIrVal/1200,
            mortgage = smcfTaVal - smcfDpVal,
            power = Math.pow((1+i), (smcfApVal*12)),
            totalMortgage = (smcfTaVal - smcfDpVal)*( (i*power)/(power-1) ),
            tmwi = totalMortgage*smcfApVal*12,
            tmwdp = tmwi+parseInt(smcfDpVal);


        $("#smcf-output").html("<p>For a mortgage of $"+mortgage+" amortized over "+smcfIrVal+" years, your Monthly payment is:</p>" +
            "<p>Mortgage Payment: $"+numberFormat(totalMortgage, 2)+"</p>" +
            "<p>Total Mortgage with Interest: $"+numberFormat(tmwi,2)+"</p>" +
            "<p>Total with Down Payment: $"+numberFormat(tmwdp,2)+"</p>");
    }


    /*----------------------------------------------------------------------------------*/
    /* Contact Form AJAX validation and submission
     /* Validation Plugin : http://bassistance.de/jquery-plugins/jquery-plugin-validation/
     /* Form Ajax Plugin : http://www.malsup.com/jquery/form/
     /*---------------------------------------------------------------------------------- */

    if (jQuery().validate && jQuery().ajaxSubmit) {
        var submitButton = $('#smcf-submit');
        var formOptions = {
            beforeSubmit: function () {
                submitButton.attr('disabled', 'disabled');
            },
            success: function () {
                submitButton.removeAttr('disabled');
                smcFuncOutput();
            }
        };

        $("#smcf-form").validate({
            rules: {
                field: {
                    number: true,
                    min:0
                }
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit(formOptions);
            }
        });
    }
})(jQuery);