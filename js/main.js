function resetForm() {
    $("form")[0].reset();
    $("#formGroupName").removeClass("has-error");
    $("#formGroupName span").html("");
    $("#formGroupMail").removeClass("has-error");
    $("#formGroupMail span").html("");
    $("#formGroupText").removeClass("has-error");
    $("#formGroupText span").html("");
    grecaptcha.reset();
    $("#formSubmit").button('reset');
}
function submitFormFunction () {
    $("form").submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        if (checkForm()) {
            $("#formSubmit").button('loading');
            $.post($form.attr("action"), $form.serialize())
                    .done(function (data) {
                        $("#formResponse").html(data);
                        $("form")[0].reset();
                        resetForm();
                    })
                    .fail(function () {
                        alert("Une erreur s'est produite. Je vous invite ? nous contacter via votre bo?te mail personnel. Merci");
                        $("#formSubmit").button('reset');
                    });
        }
    });
}

function checkForm()
{
    var check = true;
    if (document.getElementById("nom").value === '') {
        $("#formGroupName").addClass("has-error");
        $("#formGroupName span").html("Veuillez saisir un nom");
        check = false;
    } else {
        $("#formGroupName").removeClass("has-error");
        $("#formGroupName span").html("");
    }
    if (document.getElementById("email").value === '') {
        $("#formGroupMail").addClass("has-error");
        $("#formGroupMail span").html("Veuillez saisir une adresse e-mail ");
        check = false;
    } else {
        $("#formGroupMail").removeClass("has-error");
        $("#formGroupMail span").html("");
    }
    if (document.getElementById("body").value === '') {
        $("#formGroupText").addClass("has-error");
        $("#formGroupText span").html("Veuillez saisir un texte ");
        check = false;
    } else {
        $("#formGroupText").removeClass("has-error");
        $("#formGroupText span").html("");

    }
    return check;
}

function scrollSpyFunction() {
    $('#nav>li>a').on('click', function (e) {
        e.preventDefault();
        $('#collapse').collapse('hide');
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top - 49
        }, 1000);
    });
    $('#promo-buttons-itinary').on('click', function (e) {
        e.preventDefault();
        $('#collapse').collapse('hide');
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top - 49
        }, 1000);
    });
    $('#brand-all').on('click', function (e) {
        e.preventDefault();
        $('#collapse').collapse('hide');
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top - 49
        }, 1000);
    });
    $('#brand-phone').on('click', function (e) {
        e.preventDefault();
        $('#collapse').collapse('hide');
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top - 49
        }, 1000);
    });
}

function navbarFunction() {
    $(document).ready(function () {
        setNavbarColor();
    });
    $(window).on("scroll", function () {
        setNavbarColor();
    });
}

function setNavbarColor() {
    var wn = $(window).scrollTop();
    var width = $(window).width();
    if (wn > 300) {
        $(".navbar").css("background", "#f8f8f8");
        $(".navbar").css("background-color", "#f8f8f8");
        $(".navbar").css("border-color", "#f8f8f8");
        $("#nav > li > a").css("color", "black");
        if (width < 768) {
            $("#logo-phone").attr("src", "img/logo2-phone.png");
        } else {
            $("#logo-all").attr("src", "img/logo2-all.png");
        }
    } else {
        $(".navbar").css("background", "transparent");
        $(".navbar").css("background-color", "transparent");
        $(".navbar").css("border-color", "transparent");
        $("#nav > li > a").css("color", "white");
        if (width < 768) {
            $("#logo-phone").attr("src", "img/logo2inv-phone.png");
        } else {
            $("#logo-all").attr("src", "img/logo2inv-all.png");
        }
    }
}
