var $weather = {};

$weather.selectCities = function (self) {
    let cityCode = $(self).val();

    $.ajax({
        url: '/',
        method: 'post',
        dataType: 'json',
        data: {code: cityCode},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            // data.weather.condition
        }
    });
}

$weather.init = function () {
    $("#cities").change(function () {
        $weather.selectCities(this);
    }).change();
}

$weather.init();


var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};

function success(pos) {
    var crd = pos.coords;

    console.log('Ваше текущее местоположение:');
    console.log(`Широта: ${crd.latitude}`);
    console.log(`Долгота: ${crd.longitude}`);
    console.log(`Плюс-минус ${crd.accuracy} метров.`);
};

function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
};

navigator.geolocation.getCurrentPosition(success, error, options);

// cities
