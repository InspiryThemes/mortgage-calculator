(function ($) {

    'use strict';
    // Restrict output to 2 digits after point
    function numberFormat(val, decimalPlaces) {

        var multiplier = Math.pow(10, decimalPlaces);
        return (Math.round(val * multiplier) / multiplier).toFixed(decimalPlaces);
    }

    //Main output Function
    function smcFuncOutput(){

        // Getting input values
        var outputDiv = $("#smcf-output"),
            smcfTaVal = Number( $("#smcf-total-amount").val() ),
            smcfDpVal = Number( $("#smcf-down-payment").val() ),
            smcfIrVal = Number( $("#smcf-interest-rate").val() ),
            smcfApVal = Number( $("#smcf-amortization-period").val() );

        //Calculating interest by this formula interest/(months*100)
        var interest = smcfIrVal/1200;

        //Calculating mortgage by subtracting Down Payment from Total Amount
        var mortgage = smcfTaVal - smcfDpVal;

        // Power calculating by this formula Math.pow(base, exponent)
        var power = Math.pow((1+interest), (smcfApVal*12));

        // Calculating total mortgage
        var totalMortgage =  mortgage*(interest*power)/(power-1);

        //Total Mortgage with Interest
        var tmwi = totalMortgage*smcfApVal*12;

        //Total with Down Payment
        var tmwdp = tmwi+smcfDpVal;

        outputDiv.stop(true, true).slideDown();

        outputDiv.html("<p>For a mortgage of $"+mortgage+" amortized over "+smcfIrVal+" years, your Monthly payment is:</p>" +
            "<p>Mortgage Payment: $"+numberFormat(totalMortgage, 2)+"</p>" +
            "<p>Total Mortgage with Interest: $"+numberFormat(tmwi, 2)+"</p>" +
            "<p>Total with Down Payment: $"+numberFormat(tmwdp, 2)+"</p>");
    }


    // Form validation and submission
    if ( jQuery().validate ) {
        $("#smcf-form").validate({
            rules: {
                field: {
                    number: true,
                    min:0
                }
            },
            submitHandler: function() {
                smcFuncOutput();
            }
        });
    }

})(jQuery);