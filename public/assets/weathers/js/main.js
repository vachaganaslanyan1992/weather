var $weather = {};
$weather.temperature = 0;
$weather.page = 1;

$weather.getCities = function () {
    $(document).find("#bs-select-1").scroll(function () {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            $weather.page++;
            $.ajax(
                {
                    url: "api/cities?page=" + $weather.page,
                    type: "get",
                    success: function (data) {
                        $.map(data.cities, function (city) {
                            $("#cities").append("<option value='" + city.code + "'>" + city.name + "</option>")
                        });
                        $("#cities").selectpicker('refresh');
                    }
                });
        }
    });
}

$weather.hideCountryList = function () {
    $(".countries-list").hide();
}

$weather.calculateCF = function () {
    if ($("input[name='deg']:checked").val() === "f") {
        let far = ($weather.temperature * 9 / 5) + 32;
        $(".temperature").html(far.toFixed(0));
    } else {
        $(".temperature").html($weather.temperature);
    }
}

$weather.chooseCity = function () {
    $("#cities").change(function () {
        $weather.choosePlace({code: $(this).val()});
    });
}

$weather.successLocation = function (pos) {
    let crd = pos.coords;
    $weather.choosePlace({lat: crd.latitude, long: crd.longitude}, true);
}

$weather.errorLocation = function (err) {
    $weather.choosePlace({code: 616052}, true);
}

$weather.chooseLocation = function () {
    $(".current-location").click(function () {
        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };
        navigator.geolocation.getCurrentPosition($weather.successLocation, $weather.errorLocation, options);
    }).click();
}

$weather.changeCity = function () {
    $(".change-city").click(function () {
        $(".countries-list").show();
        let cityName = $(".selected-city").text();
        $(".filter-option-inner-inner").html(cityName);
    });
}

$weather.choosePlace = function (params, showContainer = false) {
    $.ajax({
        url: "/api",
        method: "post",
        dataType: "json",
        data: params,
        success: function (data) {
            $weather.hideCountryList();

            $(".selected-city").html(data.weather.name);
            $(".weather-icon img").attr("src", data.weather.clouds.image);
            $(".temperature-description").html(data.weather.clouds.description);

            $weather.temperature = data.weather.temp;
            $(".temperature").html($weather.temperature);

            $(".wind").html(data.weather.wind.speed + " m/s, " + data.weather.wind.direction);
            $(".pressure").html(data.weather.pressure + " hPa");
            $(".humidity").html(data.weather.humidity + "%");
            $(".chance-rain").html(data.weather.clouds.percent + "%");

            $weather.calculateCF();

            if (showContainer) {
                $(".container-fluid").show();
            }
        }
    });
}

$weather.init = function () {
    $weather.chooseCity();
    $weather.changeCity();
    $weather.chooseLocation();
    $(".countries-list").click(function () {
        $weather.getCities();
    });
    $(".deg").change(function () {
        $weather.calculateCF();
    });
}

$weather.init();
