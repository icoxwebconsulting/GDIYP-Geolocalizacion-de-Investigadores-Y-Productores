var redefinesearch = $("#redefinesearch").val();
var searchcountry = $("#searchcountry").val();
var searchregion = $("#searchregion").val();
var searchcity = $("#searchcity").val();
var searchtypeuser = $("#searchtypeuser").val();

function loadMap(url, type) {
    var _latitude = 25.541216;
    var _longitude = -0.095678;

    createHomepageGoogleMap(_latitude, _longitude, []);

    $.ajax({
        type: "GET",
        url: url,
        data: {
            usertype: type
        }
    }).done(function (result) {

        if (result.length < 1)
            $("#alertNews").show();

        createHomepageGoogleMap(_latitude, _longitude, result);
        $("#mapLoader").hide();
        $(".iconLeftBar").trigger("click");


    }).fail(function (jqxhr, textStatus, error) {
        console.log(error);
    });
}

// Set if language is RTL and load Owl Carousel
$(window).load(function () {
    var rtl = false; // Use RTL
    initializeOwl(rtl);
});


if (redefinesearch == '1') {
    if (searchtypeuser != "") {
        $("#type-user").val(searchtypeuser);
        $("#advanced-search").removeClass('disabled');
    }
}

$('#country').change(function () {
    loadRegion();
});
$('#region').change(function () {
    loadCity();
});

function loadCountry() {
    $.ajax({
        type: "GET",
        url: Routing.generate('country_list', {id: region})
    }).done(function (result) {
        var data = eval(result);
        for (var i = 0; i < data.length; i++) {
            var newOption = $('<option/>');
            newOption.text(data[i].name);
            newOption.attr('value', data[i].id);
            if (redefinesearch == '1' && searchcountry == data[i].id)
                newOption.attr('selected', true);
            $('#country').append(newOption);
        }
        var country = $('#country').find(':selected').val();
        if (country != 0) {
            loadRegion();
        }
    });
}

function loadRegion() {
    $("#region").children().remove();
    var country = $('#country').find(':selected').val();
    if (country != 0) {
        $.ajax({
            type: "GET",
            url: Routing.generate('region_list', {id: country})
        }).done(function (result) {
            var data = eval(result);
            for (var i = 0; i < data.length; i++) {
                var newOption = $('<option/>');
                newOption.text(data[i].name);
                newOption.attr('value', data[i].id);
                if (redefinesearch == '1' && searchregion == data[i].id)
                    newOption.attr('selected', true);
                $('#region').append(newOption);
            }
            loadCity();
        });
    }
}

function loadCity() {
    $("#city").children().remove();
    var region = $('#region').find(':selected').val();
    if (region != 0) {
        $.ajax({
            type: "GET",
            url: Routing.generate('city_list', {id: region})
        }).done(function (result) {
            var data = eval(result);
            for (var i = 0; i < data.length; i++) {
                var newOption = $('<option/>');
                newOption.text(data[i].name);
                newOption.attr('value', data[i].id);
                if (redefinesearch == '1' && searchcity == data[i].id)
                    newOption.attr('selected', true);
                $('#city').append(newOption);
            }
        });
    }
}

loadCountry();

$('#search-form').bind('submit', function (e) {
    $("#mapLoader").show();
    e.preventDefault();
    var city = $('#city').find(':selected').val();
    type = $("#type-user").val();

    if (city != 0) {
        if (type == 'investigator')
            var url = Routing.generate('homepage_user_profile_city_show', {id: city});
        else if (type == 'producer')
            var url = Routing.generate('homepage_practice_profile_city_show', {id: city});
        else if (type == 'all')
            var url = Routing.generate('homepage_all_profile_city_show', {id: city});

        loadMap(url, type);
    }
});

