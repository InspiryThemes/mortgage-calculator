(function ($) {

    'use strict';
    // Restrict output to 2 digits after point
    function numberFormat(val, decimalPlaces) {

        var multiplier = Math.pow(10, decimalPlaces);
        return (Math.round(val * multiplier) / multiplier).toFixed(decimalPlaces);
    }

    //Main output Function
    function mcOutputFunc(){

        // Getting input values
        var outputDiv = $("#mc-output");

        // Getting total amount value from user
        var mcTotalAmount = Number( $("#mc-total-amount").val() );

        //Getting Down Payment value from user
        var mcDownPayment = Number( $("#mc-down-payment").val() );

        //Getting Interest Rate value from user
        var mcInterestRate = Number( $("#mc-interest-rate").val() );

        //Getting Amortization period value from user
        var mcAmortizationPeriod = Number( $("#mc-amortization-period").val() );

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

       // Getting Localize php strings
        var outPutString = mc_strings.mc_output_string;

        //currency sign
        var mcCurrencySign = "$";

        outPutString = outPutString.replace( "[mortgage_amount]", mcCurrencySign+principal );
        outPutString = outPutString.replace( "[amortization_years]", mcAmortizationPeriod );
        outPutString = outPutString.replace( "[mortgage_payment]", mcCurrencySign+numberFormat(totalMortgage, 2) );
        outPutString = outPutString.replace( "[total_mortgage_interest]", mcCurrencySign+numberFormat(tmwi, 2) );
        outPutString = outPutString.replace( "[total_mortgage_down_payment]", mcCurrencySign+numberFormat(tmwdp, 2) );

        outputDiv.html( "<p>"+outPutString+"</p>");
        
        outputDiv.stop(true, true).slideDown();
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
                mcOutputFunc();
            }
        });
    }

})(jQuery);