(function ($) {

    'use strict';
    // Restrict output to 2 digits after point
    function numberFormat(val, decimalPlaces) {

        var multiplier = Math.pow(10, decimalPlaces);
        return (Math.round(val * multiplier) / multiplier).toFixed(decimalPlaces);
    }

    //Main output Function
    function mcFuncOutput(){

        // Getting input values
        var outputDiv = $("#mc-output"),

            mcTotalAmount = Number( $("#mc-total-amount").val() ),

            mcDownPayment = Number( $("#mc-down-payment").val() ),

            mcInterestRate = Number( $("#mc-interest-rate").val() ),

            mcAmortizationPeriod = Number( $("#mc-amortization-period").val() );

        //Calculating r by this formula r/(months*100)
        var r = mcInterestRate/1200;

        //Calculating principal Amount by subtracting Down Payment from Total Amount
        var principal = mcTotalAmount - mcDownPayment;

        // Power calculating by this formula Math.pow(base, exponent)
        var power = Math.pow((1+r), (mcAmortizationPeriod*12));

        // Calculating total mortgage
        var totalMortgage =  principal*(r*power)/(power-1);

        //Total Mortgage with Interest
        var tmwi = totalMortgage*mcAmortizationPeriod*12;

        //Total with Down Payment
        var tmwdp = tmwi+mcDownPayment;

        outputDiv.stop(true, true).slideDown();

        outputDiv.html("<p>For a mortgage of $"+principal+" amortized over "+mcAmortizationPeriod+" years, your Monthly payment is:</p>" +
            "<p>Mortgage Payment: $"+numberFormat(totalMortgage, 2)+"</p>" +
            "<p>Total Mortgage with Interest: $"+numberFormat(tmwi, 2)+"</p>" +
            "<p>Total with Down Payment: $"+numberFormat(tmwdp, 2)+"</p>");
    }


    // Form validation and submission
    if ( jQuery().validate ) {
        $("#mc-form").validate({
            rules: {
                field: {
                    number: true,
                    min:0
                }
            },
            submitHandler: function() {
                mcFuncOutput();
            }
        });
    }

})(jQuery);