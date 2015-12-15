
$(function () {
    // with the images referenced as a material box css class, zoom it out when
    // when the user click on it
    $('.materialboxed').materialbox();

    // with the add item card referenced as a modal css class, activate or trigger
    // the modal on the float action button click
    $('.modal-trigger').leanModal();

    // activate the side menu referenced as the button collapse
    // on window shrink
    $(".button-collapse").sideNav();
});



