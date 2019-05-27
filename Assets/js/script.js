$(document).ready(function () {
    $('#trigger').click(function(e){
        e.preventDefault();
        $('#slider').toggleClass('show');
        $('.post-wrapper').toggleClass('change');
    });
    $("#datepicker").datepicker();
    $("#expiredatepicker").datepicker();
    $('#timepicker').clockpicker({
        autoclose: true,
    });
    $('#expiretimepicker').clockpicker({
        autoclose: true,
        placement: 'top',
    });
});