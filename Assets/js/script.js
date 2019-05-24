$(document).ready(function () {
    $('#trigger').click(function(e){
        e.preventDefault();
        $('#slider').toggleClass('show');
        $('.post-wrapper').toggleClass('change');
    });
    
});