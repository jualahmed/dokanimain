jQuery(document).ready(function($) {
	$(".alert").fadeTo(2000, 500).slideUp(500, function(){
	  $(".alert").slideUp(500);
	});
	$('#datepicker').datepicker({
        autoclose: true
      });
    $('#datepickerr').datepicker({
        autoclose: true
      });
    $('#datepickerrr').datepicker({
        autoclose: true
      });
    $('#datepicker2').datepicker({
        autoclose: true
      });
    $('#datepickerrrrrrrr').datepicker({
        autoclose: true
      });
    $('#datepickerrrrrrrrrr').datepicker({
        autoclose: true
      });
    $('#datepickerrrrrrrrr').datepicker({
        autoclose: true
      });
    $('#datepickerrrrrrrrrrrr').datepicker({
        autoclose: true
      });
    
    $('#datepickerrrrdfsdfsdfrrrrrrrr').datepicker({
        autoclose: true
      });
    $('#datepickerrrrdfsdffsdfrrrrrrrr').datepicker({
        autoclose: true
      });
    
    
    $('#datep').datepicker({
        autoclose: true
      });
    
    $('#datasep').datepicker({
        autoclose: true
      });
    $('#datepp').datepicker({
        autoclose: true
      });
    $('#datep2').datepicker({
        autoclose: true
      });
    
    $('#datep22').datepicker({
        autoclose: true
      });
    $('#datep23').datepicker({
        autoclose: true
      });
    
    $('#datedate').datepicker({
        autoclose: true
      });
    $('#start').datepicker({
        autoclose: true
      });
    $('#end').datepicker({
        autoclose: true
    });
});

jQuery(document).ready(function(){
    jQuery('.scrollbar-outer').scrollbar();
});

function convert_number_to_words(number){
    var hyphen        = '-';
    var conjunction   = ' AND ';
    var separator     = ', ';
    var negative      = 'NEGATIVE ';
    var decimal       = ' POINT ';
    var dictionary    = [];
    dictionary[0]     = 'ZERO';
    dictionary[1]     = 'ONE';
    dictionary[2]     = 'TWO';
    dictionary[3]     = 'THREE';
    dictionary[4]     = 'FOUR';
    dictionary[5]     = 'FIVE';
    dictionary[6]     = 'SIX';
    dictionary[7]     = 'SEVEN';
    dictionary[8]     = 'EIGHT';
    dictionary[9]     = 'NINE';
    dictionary[10]    = 'TEN';
    dictionary[11]    = 'ELEVEN';
    dictionary[12]    = 'TWELVE';
    dictionary[13]    = 'THIRTEEN';
    dictionary[14]    = 'FOURTEEN';
    dictionary[15]    = 'FIFTEEN';
    dictionary[16]    = 'SIXTEEN';
    dictionary[17]    = 'SEVENTEEN';
    dictionary[18]    = 'EIGHTEEN';
    dictionary[19]    = 'NINETEEN';
    dictionary[20]    = 'TWENTY';
    dictionary[30]    = 'THIRTY';
    dictionary[40]    = 'FOURTY';
    dictionary[50]    = 'FIFTY';
    dictionary[60]    = 'SIXTY';
    dictionary[70]    = 'SEVENTY';
    dictionary[80]    = 'EIGHTY';
    dictionary[90]    = 'NINETY';
    dictionary[100]   = 'HUNDRED';
    dictionary[1000]      = 'THOUSAND';
    dictionary[1000000]     = 'MILLION';
    dictionary[1000000000]    = 'BILLION';
    dictionary[1000000000000]   = 'TRILLION';
    dictionary[1000000000000000]  = 'QUADRILLION';
    dictionary[1000000000000000000] = 'QUINTILLION';

    if(isNaN(number)){
            return false;
    }
    if(number < 0){
            return negative + convert_number_to_words(Math.abs(number));
    }

    var string = ""; var fraction = "";

    if (number.toString().indexOf('.')) {
        var tmp     = [];
        tmp         = number.toString().split(".");
        number      = tmp[0];
        fraction    = tmp[1];
    }

    switch(true){
        case number < 21:
        string = dictionary[number];
        break;

        case number < 100:
            var tens    = parseInt((number / 10)) * 10;
            var units   = number % 10;
            string  = dictionary[tens];
            if (units) {
                string += hyphen + dictionary[units];
            }
            break;

        case number < 1000:
            var hundreds  = parseInt(number / 100);
            var remainder = (number % 100);
            string = dictionary[hundreds] + ' ' + dictionary[100];
            if (remainder) {
                string += conjunction + convert_number_to_words(remainder);
            }
            break;

        default:
            var tmp         = Math.log(number) / Math.log(1000);
            var baseUnit    = Math.pow(1000, Math.floor(tmp));

        var numBaseUnits    = parseInt(number / baseUnit);
        var remainder       = parseInt(number % baseUnit);
        string              = convert_number_to_words(numBaseUnits) + ' ' + dictionary[baseUnit];
        if (remainder) {
            string += remainder < 100 ? conjunction : separator;
            string += convert_number_to_words(remainder);
        }
        break;
    }

    if("" != fraction && !isNaN(fraction)){
        string  += decimal;
        $.each(fraction.toString().split(""), function(key, number) {
            string += dictionary[number] + ' ';
        });
    }
    return string;
}