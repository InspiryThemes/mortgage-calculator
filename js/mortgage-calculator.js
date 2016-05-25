(function ($) {

    'use strict';

    // Restrict output to 2 digits after point
    function numberFormat(val, decimalPlaces) {

        var multiplier = Math.pow(10, decimalPlaces);
        return (Math.round(val * multiplier) / multiplier).toFixed(decimalPlaces);
    }

    //Main output Function
    function mcOutputFunc(){

        // Getting output div id
        var outputDiv = $("#mc-output");

        // Getting total amount value from user
        var mcTotalAmount = parseFloat( $("#mc-total-amount").val() );

        //Getting down payment value from user
        var mcDownPayment = parseFloat( $("#mc-down-payment").val() );

        //Getting interest rate value from user
        var mcInterestRate = parseFloat( $("#mc-interest-rate").val() );

        //Getting mortgage period value from user
        var mcAmortizationPeriod = parseFloat( $("#mc-mortgage-period").val() );

        //Calculating r by this formula ( (InterestRate/100)/12 )
        var r = ( ( mcInterestRate / 100 ) / 12 );

        //Calculating principal amount by subtracting down payment from total amount
        var principal = mcTotalAmount - mcDownPayment;

        // Power calculating by this formula Math.pow(base, exponent)
        var power = Math.pow( ( 1 + r ), ( mcAmortizationPeriod * 12 ) );

        // Calculating total mortgage
        var monthlyMortgage =  principal * ( ( r * power ) / ( power - 1 ) );

        //Total mortgage with interest
        var tmwi = monthlyMortgage * mcAmortizationPeriod * 12;

        //Total with down payment
        var tmwdp = tmwi + mcDownPayment;

       // Getting localize php strings
        var outPutString = mc_strings.mc_output_string;

        //Currency sign
        var mcCurrencySign = "$";

        outPutString = outPutString.replace( "[mortgage_amount]", mcCurrencySign+principal );
        outPutString = outPutString.replace( "[amortization_years]", mcAmortizationPeriod );
        outPutString = outPutString.replace( "[mortgage_payment]", mcCurrencySign+numberFormat( monthlyMortgage, 2 ) );
        outPutString = outPutString.replace( "[total_mortgage_interest]", mcCurrencySign+numberFormat( tmwi, 2 ) );
        outPutString = outPutString.replace( "[total_mortgage_down_payment]", mcCurrencySign+numberFormat( tmwdp, 2 ) );

        //Displaying output div
        outputDiv.html( "<p>"+outPutString+"</p>").stop(true, true).slideDown();
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