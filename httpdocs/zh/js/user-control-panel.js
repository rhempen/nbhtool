$('#change-pw').on('submit', function () {

    if($.trim($('#new_pw_1').val()) !== $.trim($('#new_pw_2').val()))
    {
        $('#new_pw_1-div').addClass('has-error');
        $('#new_pw_2-div').addClass('has-error');
        $('#new_pw_2-div label').text('Passwort bitte korrekt wiederholen');
        return false;
    }
    var pw_policy = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$", "g");
    if(!pw_policy.test($.trim($('#new_pw_2').val())))
    {
        $('#new_pw_1-div').addClass('has-error');
        $('#new_pw_2-div').addClass('has-error');
        $('#new_pw_2-div label').text('Passwort muss mindestens 8 Zeichen lang sein, Grossbuchstaben, Kleinbuchstaben und mindestens eine Zahl enthalten');
        return false;
    }
});
