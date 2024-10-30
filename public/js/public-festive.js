(function ($) {
    "use strict";

    var ajaxUrl = "https://divineapi.com/divines/verifyDomain";
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var api_key = fapi_options.api_key;
    var access_token = fapi_options.access_token;
    var timezone = fapi_options.timezone;
    var background_color = fapi_options.background_color;
    var primary_festival_badge = fapi_options.primary_festival_badge;
    var secondary_festival_badge = fapi_options.secondary_festival_badge;
    var festival_loader = fapi_options.festival_loader;
    var plgn_base_url = fapi_options.plgn_base_url;
    var lat = fapi_options.lat;
    var lon = fapi_options.lon;

    if (background_color.length > 0) 
    {
        document.documentElement.style.setProperty('--background_color', background_color);
    }
    if (primary_festival_badge.length > 0) 
    {
        document.documentElement.style.setProperty('--primary_festival_badge', primary_festival_badge);
    }
    if (secondary_festival_badge.length > 0) 
    {
        document.documentElement.style.setProperty('--secondary_festival_badge', secondary_festival_badge);
    }
    if (festival_loader.length > 0) 
    {
        document.documentElement.style.setProperty('--festival_loader', festival_loader);
    }

    $('#month').val(fapi_options.c_month);
    $('#year').val(fapi_options.c_year);
    var month = $('#month').val();
    var year = $('#year').val();
    var selected_location = '';
    var years_loaded = [];

    var festivalDataArray = [
        // { date: "2023-07-01", value: "Data 1", details: "Detail 1" },
    ];

    function isLocalhost(url) {
        return url.includes('localhost') || url.includes('127.0.0.1');
    }
    $(document).ready(function () {
        if (verified_domain(api_key) == 1) {
            $('#festive-auth').hide();
            // $.getScript(
            //     "https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMap",
            //     function () {
            //         // alert('Load was performed.');
            //         function initMap() {
            //             const elevator = new google.maps.ElevationService();
            //             var input = document.getElementById("fapi-location");
            //             var autocomplete = new google.maps.places.Autocomplete(input);
            //             autocomplete.addListener("place_changed", function () {
            //                 var place = autocomplete.getPlace();
            //                 timezone = place.utc_offset_minutes;
            //                 displayLocationElevation(place.geometry.location, elevator);
            //                 $("#fapi-location").val(place.formatted_address);
            //                 // document.getElementById("timezone").value = place.utc_offset_minutes;
            //                 // document.getElementById("place_id").value = place.place_id;
            //             });
            //         }

            //         function displayLocationElevation(location, elevator) {
            //             elevator
            //                 .getElevationForLocations({
            //                     locations: [location],
            //                 })
            //                 .then(({ results }) => {
            //                     lat = results[0].location.lat();
            //                     lon = results[0].location.lng();
            //                     $("#fapi-lat").val(lat);
            //                     $("#fapi-lon").val(lon);
            //                     //timezone = ui.item.tzone;    
            //                     // document.getElementById("elevation").value = results[0].elevation;
            //                     // document.getElementById("latitude").value = results[0].location.lat();
            //                     // document.getElementById("longitude").value = results[0].location.lng();
            //                 })
            //                 .catch((e) =>
            //                     console.log("Elevation service failed due to: " + e)
            //                 );
            //         }
            //     }
            // );
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMap();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMap();
            //     });
            // }
            selected_location = $('#fapi-location').val();
            $("#fapi-location").on("focusout", function () {
                if ($("#fapi-location").val() != "") {
                    setTimeout(function () {
                        lat = window.lat;
                        lon = window.lon;
                        timezone = window.timezone;
                        //get_all_data(lat, lon, timezone);
                        festivalDataArray = [];
                        years_loaded = [];
                        getFestivals();
                    }, 600);
                }
            });

            $("#fapi-location").on("click", function () {
                selected_location = $('#fapi-location').val();
                $("#fapi-location").val("");
            });

            $("#fapi-location").on("focusout", function () {
                $("#fapi-location").val(selected_location);
            });
            renderCalender();
            $('#fapiloader').show();
            getFestivals();
        }
        else {
            $('#festive-auth p').html("** You can use this API key only for registerd website on divine **");
            $('#fapi-subdiv').hide();
        }
    });

    function verified_domain(api_key) {
        var verResponse = 0;
        // alert(api_key);
        var getRequesturl = window.location.href;
        var getRequesthost = window.location.host;
        if (!isLocalhost(getRequesturl)) {
            var subdomain = getRequesthost.split('.')[0];

            const result2 = Array.from(set).includes(subdomain);
            if (result2) {
                var sub = subdomain + '.';
                getRequesthost = getRequesthost.replace(sub, "");
            }
            jQuery.ajax({
                url: ajaxUrl,
                method: 'post',
                async: false,
                data: { api_key: api_key, domain: getRequesthost },
                success: function (data) {
                    var response = jQuery.parseJSON(data);
                    verResponse = response.success;
                }
            });
            return verResponse;
        } else {
            return true;
        }
    }

    $('#month').on('change', function () {
        $("#data").empty();
        renderCalender();
    });

    $('#year').on('change', function () {
        // years_loaded.find($('#year').val());
        let find_year = $('#year').val();
        if (!years_loaded.includes(find_year)) {
            // console.log(years_loaded);
            getFestivals();
        } else {
            renderCalender();
            $("#fapiloader").show();
            $("#calender-container").hide();
            $("#data").empty();
            setTimeout(function () {
                // $("#fapiloader").hide();
                // $("#calender-container").hide();
                renderCalender();
            }, 2000);
        }
        // console.log(years_loaded);
    });

    // function checkYear(year){
    //     if( year){

    //     }

    // }

    $(document).on("click", ".fapidate", function () {
        var text = $(this).contents().filter(function () {
            return this.nodeType === 3;
        }).text().trim();
        var dates = `${$("#year").children("option:selected").val()}-${$("#month")
            .children("option:selected")
            .val()}-${text}`;

        var data = showData(dates);
        $("#data").empty();
        $("#data").append(data);
    });

    function showData(date) {
        var filterData = festivalDataArray.filter(function (item) {
            return item.date === date;
        });
        var html = "";
        if (filterData.length > 0) {
            html += "<h4>Festivals on " + date + "</h4>";
            html += "<ul class='fapidata-list'>";
            filterData.forEach(function (item) {
                if (item.details && item.details != null) {

                    // html += "<li class='fapidata-item'><img src=''>" + item.value + " " + item.details + "</li>";
                    html += "<li class='fapidata-item'><img src='"+plgn_base_url+"public/images/festival.png'>" + item.value + " " + item.details + "</li>";
                    // html += "<li class='fapidata-item'><img class='dapi_img' src="+plgn_base_url+'public/images/panchang/sun-moon/sunrise.svg'/>" + item.value + " " + item.details + "</li>';

                } else {

                    html += "<li class='fapidata-item'><img src='"+plgn_base_url+"public/images/festival.png'>" + item.value + "</li>";
                }
            });
            html += "</ul>";
            return html;
        } else {
            html += "<p>No data available for this day</p>";
            return html;
        }
    }

    function renderCalender() {
        month = $('#month').val();
        year = $('#year').val();
        // alert(month+' , ' + year);
        // exit();
        // var apifestivalcalldata =dataparameters(api_key,access_token,year,month,lat,lon,timezone);
        var container = $("#calender-container");
        container.empty();

        var date = new Date(month, year, 1);
        var monthName = date.toLocaleString("default", { month: "long" });

        var table = $("<table>");
        var thead = $("<thead>");
        var tbody = $("<tbody>");

        var headerRow = $("<tr>");
        var headerCell = $("<th>")
            .attr("colspan", 7)
            .text(monthName + " " + year);
        headerRow.append(headerCell);
        //thead.append(headerRow);

        var weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

        var weekdaysRow = $("<tr>");

        for (var i = 0; i < weekdays.length; i++) {
            var weekdaysCell = $("<th>").text(weekdays[i]);
            weekdaysRow.append(weekdaysCell);
        }
        thead.append(weekdaysRow);

        // var DaysInMonth = new Date(year, month + 1, 0).getDate();
        var DaysInMonth = new Date(year, month, 0).getDate();

        var startingDay = new Date(year + "-" + month + "-01").getDay();
        // alert(DaysInMonth)
        var currentDay = 1;
        for (var i = 0; i < 6; i++) {
            var row = $("<tr>");
            for (var j = 0; j < 7; j++) {
                if (i === 0 && j < startingDay) {
                    var cell = $("<td>");
                    row.append(cell);
                } else if (currentDay > DaysInMonth) {
                    break;
                } else {
                    var cell =
                        currentDay >= 10
                            ? $("<td>").text(currentDay)
                            : $("<td>").text(`0${currentDay}`);
                    //var cell = ;
                    cell.addClass("fapidate");
                    row.append(cell);
                    var dataForDate = getDataForDate(year, month, currentDay);
                    if (dataForDate.length > 0) {
                        var dataList = $('<ul class="fapicell-data">');
                        dataForDate.forEach(function (item) {
                            var listItem = $('<li class="fapimenu">').text(item.substring(0, 14)).addClass("fapicell-data-item");
                            // var listItem = $('<li>');
                            dataList.append(listItem);
                        });
                        cell.append(dataList);
                    }
                    //showData(currentDay);
                    currentDay++;
                }
            }
            tbody.append(row);
        }
        table.append(thead);
        table.append(tbody);
        container.append(table);
        $('#fapiloader').hide();
        // $('#fapiloader2').hide();
        $('#calender-container').show();
        $(".fapi-message").show();
    }

    function getDataForDate(year, month, currentDay) {

        if (currentDay >= 10) {
            var date = `${year}-${month}-${currentDay}`
        }
        else {
            var date = `${year}-${month}-0${currentDay}`
        }

        var filterData = festivalDataArray.filter(function (item) {
            return item.date === date;
        });

        return filterData.map(function (item) {
            return item.value;
        })
    }
    function getFestivals() {
        years_loaded.push($('#year').val());
        $("#fapiloader").show();
        // $("#calender-container").hide();
        $("#data").empty();
        $(".fapi-message").hide();
        setTimeout(function () {
            // renderCalender();
            magha_festivals();
            pausha_festivals();
            phalguna_festivals();
            vaishakha_festivals();
            jyeshtha_festivals();
            ashada_festivals();
            shraavana_festivals();
            bhadrapada_festivals();
            ashvina_festivals();
            kartika_festivals();
            margashirsh_festivals();
            chaitra_festivals();
            // $("#fapiloader").hide();
            // $("#calender-container").show();
        }, 100);
    }

    function magha_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/magha-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                    console.log('done');
                }
            });
        } catch (e) {
            console.log('Error in get magha festivals: ' + e);
        }
    }

    function phalguna_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/phalguna-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },

                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get phalguna festivals: ' + e);
        }
    }

    function chaitra_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/chaitra-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get chaitra festivals: ' + e);
        }
    }

    function vaishakha_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/vaishakha-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get vaishakha festivals: ' + e);
        }
    }

    function jyeshtha_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/jyeshtha-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get jyeshtha festivals: ' + e);
        }
    }

    function ashada_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/ashada-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get ashada festivals: ' + e);
        }
    }

    function shraavana_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/shraavana-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get shraavana festivals: ' + e);
        }
    }

    function bhadrapada_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/bhadrapada-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get bhadrapada festivals: ' + e);
        }
    }

    function ashvina_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/ashvina-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get ashvina festivals: ' + e);
        }
    }

    function kartika_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/kartika-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },

                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get kartika festivals: ' + e);
        }
    }

    function margashirsh_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/margashirsh-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get margashirsh festivals: ' + e);
        }
    }

    function pausha_festivals() {
        try {
            year = $('#year').val();
            month = $('#month').val();
            jQuery.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/pausha-festivals',
                method: 'post',
                headers: { "authorization": "Bearer " + access_token },
                // async: false,
                data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
                
                success: function (response) {
                    var festivals = response.data.widget;
                    getFestivalsdata(festivals);
                    renderCalender();
                }
            });
        } catch (e) {
            console.log('Error in get pausha festivals: ' + e);
        }
    }

    function getFestivalsdata(festivals) {
        for (const key in festivals) {
            let details_data = '';
            var data = festivals[key];
            if (typeof data.name !== 'undefined') {
                // console.log(data.name);
                let details = data.details
                for (const key in details) {
                    details_data += "<p>" + details[key] + "</p>";
                }
                festivalDataArray.push(
                    {
                        date: data.date, value: data.name, details: details_data
                    }
                );
            } else {
                for (const key in data) {
                    details_data = '';
                    let temp_data = data[key];
                    // console.log(temp_data);
                    let details = temp_data.details;
                    for (const key in details) {
                        details_data += "<p>" + details[key] + "</p>";
                    }
                    festivalDataArray.push(
                        {
                            date: temp_data.date, value: temp_data.name, details: details_data
                        }
                    );
                    // console.log(data[key]);
                }
            }
        }
    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);
