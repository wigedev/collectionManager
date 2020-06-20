Site = Site || {};

Site.login = function login() {
    let username = $("#inputUsername").val(),
        password = $("#inputPassword").val();
    console.log(username, password);
    $.post( "/index/index/login", { username: username, password: password })
        .done(function( data ) {
            alert( "Data Loaded: " + data );
        });
}


$(function () {

});