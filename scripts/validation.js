$("#yes-news").on("change", function() {
    $("#subscription-email-label").removeClass("hidden");
    $("#request-subscription-email").removeClass("hidden");
        $("#request-subscription-email").attr("required", true);
})
// TODO: when user selects cash option
$("#no-news").on("change", function() {
    $("#subscription-email-label").addClass("hidden");
    $("#request-subscription-email").addClass("hidden");
    $("#feedback-subscription-email").addClass("hidden");
        $("#request-subscription-email").attr("required", false);
})

$("#request-form").on("submit", function() {
    var formValid = true;

    if ( $("#request-email").prop("validity").valid ) {
        $("#feedback-email").addClass("hidden");
    } else {
        $("#feedback-email").removeClass("hidden");

        formValid = false;
    };

    if( $("#request-time").is(":checked") ||
    $("#request-product").is(":checked") ||
    $("#request-size").is(":checked") ||
    $("#request-other").is(":checked") ) {
        $("#feedback-information").addClass("hidden");
    } else {
        $("#feedback-information").removeClass("hidden");

        formValid = false;
    };

    if ( $("#request-subscription-email").prop("validity").valid ) {
        $("#feedback-subscription-email").addClass("hidden");
    } else {
        $("#feedback-subscription-email").removeClass("hidden");

        formValid = false;
    };

    return formValid;
})
