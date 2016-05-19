(function ($) {

    'use strict';

    $("#smcf-submit").on("click", function (e) {
        var smcf_ta_val = $("#smcf-total-amount").val(),
            smcf_dp_val = $("#smcf-down-payment").val(),
            smcf_ir_val = $("#smcf-interest-rate").val(),
            smcf_ap_val = $("#smcf-amortization-period").val();
       
        var i = smcf_ir_val/1200,
            power = Math.pow((1+i), (smcf_ap_val*12)),
            M = (smcf_ta_val - smcf_dp_val)*( (i*power)/(power-1) );
        $("#smcf-output").html("Mortgage Payment: "+M);
        e.preventDefault();
    });


})(jQuery);