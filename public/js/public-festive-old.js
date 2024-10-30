(function ($) {
  "use strict";

  var ajaxUrl = "https://divineapi.com/divines/verifyDomain";
  const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

  var api_key = fapi_options.api_key;
  var access_token = fapi_options.access_token;
  var timezone = fapi_options.timezone;
  var lat = fapi_options.lat;
  var lon = fapi_options.lon;
  $('#months').val(fapi_options.c_month);
  $('#year').val(fapi_options.c_year);
  var festivalDataArray = [
    { date: "2023-07-01", value: "Data 1", details: "Detail 1" },
  ];


  // var currentDate = new Date();
  // var year = currentDate.getFullYear();
  // var month = currentDate.getMonth();
  // if(month<10){
  //   month = 
  // }

  var year = $("#year").children("option:selected").val();
  var month = $("#months").children("option:selected").val();

  // dataparameters(api_key, access_token, year, month, lat, lon, timezone);
  // renderCalender(month, year);

  var isYearSelected = false;
  var isMonthSelected = false;
  $("#year").change(function () {
    // document.getElementById('fapiloader').style.display = '';
    // document.getElementById('calender-container').style.display = 'none';
    year = parseInt($(this).children("option:selected").val());
    if (month != '' && month != undefined && month != 'undefined') {
      isMonthSelected = true;
    }
    isYearSelected = true;
    if (isMonthSelected && isYearSelected) {
      month = $("#months").children("option:selected").val();
      renderCalender(month, year);
    }
    $("#fapiloader2").show();
    setTimeout(function () {
      // $("#calender-container").hide();
      // dataparameters(api_key, access_token, year, month, lat, lon, timezone);
    }, 10);
  });

  $("#months").change(function () {
    // document.getElementById('fapiloader').style.display = '';
    // document.getElementById('calender-container').style.display = 'none';
    month = $(this).children("option:selected").val();
    if (month != '' && month != undefined && month != 'undefined') {

      isYearSelected = true;
    }
    isMonthSelected = true;
    if (isMonthSelected && isYearSelected) {
      year = parseInt($("#year").children("option:selected").val());
      renderCalender(month, year);
    }
    // $("#fapiloader2").show();
    // setTimeout(function () {
    //   $("#calender-container").hide();
    //   dataparameters(api_key, access_token, year, month, lat, lon, timezone);
    // }, 10);
  });

  function renderCalender(month, year) {


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
    $('#fapiloader2').hide();
    $('#calender-container').show();
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

          html += "<li class='fapidata-item'>" + item.value + " " + item.details + "</li>";
        } else {

          html += "<li class='fapidata-item'>" + item.value + "</li>";
        }
      });
      html += "</ul>";
      return html;
    } else {
      html += "<p>No data available for this day</p>";
      return html;
    }
  }

  //Location
  var selected_location = $("#fapi-location").val();


  $(document).ready(function () {
    if (verified_domain(api_key) == 1) {
      $.getScript(
        "https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMap",
        function () {
          // alert('Load was performed.');
          function initMap() {
            const elevator = new google.maps.ElevationService();
            var input = document.getElementById("fapi-location");
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener("place_changed", function () {
              var place = autocomplete.getPlace();
              timezone = place.utc_offset_minutes;
              displayLocationElevation(place.geometry.location, elevator);
              $("#fapi-location").val(place.formatted_address);
              // document.getElementById("timezone").value = place.utc_offset_minutes;
              // document.getElementById("place_id").value = place.place_id;
            });
          }

          function displayLocationElevation(location, elevator) {
            elevator
              .getElevationForLocations({
                locations: [location],
              })
              .then(({ results }) => {
                lat = results[0].location.lat();
                lon = results[0].location.lng();
                $("#fapi-lat").val(lat);
                $("#fapi-lon").val(lon);
                //timezone = ui.item.tzone;

                // document.getElementById("elevation").value = results[0].elevation;
                // document.getElementById("latitude").value = results[0].location.lat();
                // document.getElementById("longitude").value = results[0].location.lng();




              })
              .catch((e) =>
                console.log("Elevation service failed due to: " + e)
              );
          }
        }
      );

      $("#fapi-location").on("focusout", function () {
        if ($("#fapi-location").val() != "") {
          setTimeout(function () {
            lat = window.lat;
            lon = window.lon;
            tzone = window.timezone;
            //get_all_data(lat, lon, timezone);
            getFestivals();
          }, 600);
        }
      });

      $("#fapi-location").on("click", function () {
        $("#fapi-location").val("");
      });

      $("#fapi-location").on("focusout", function () {
        $("#fapi-location").val(selected_location);
      });

    }
    else {
      $('#festive-auth p').html("** You can use this API key only for registerd website on divine **");
      $('#fapi-subdiv').hide();
    }
    // dataparameters(api_key,access_token,year,month,lat,lon,timezone);

  });

  function dataparameters(api_key, access_token, year, month, lat, lon, timezone) {
    // document.getElementById('fapiloader').innerHTML = 'Hello';
    // document.getElementById('fapiloader').style.display = 'block';
    // document.getElementById('calender-container').innerHTML = 'hello 1';
    // document.getElementById('fapiloader').style.display = '';
    // document.getElementById('calender-container').style.display = 'none';
    // alert('test');
    // $('#fapiloader').show();
    // $('#calender-container').hide();
    // alert('test2');
    // exit();
    jQuery.ajax({
      // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
      url: 'http://127.0.0.1:8000/indian-api/v1/magha-festivals',
      method: 'post',
      headers: { "authorization": "Bearer " + access_token },
      async: false,
      data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
      beforeSend: function () {
        //     document.getElementById('fapiloader').style.display = '';
        // document.getElementById('calender-container').style.display = 'none';
        // $("#calender-container").hide();
        // alert('hide');
      },
      complete: function () {
        // $('#loader').hide();
      },
      success: function (response) {
        // var response = jQuery.parseJSON(data);
        // verResponse = response.success;
        var festivals = response.data.widget;

        // festivalsdata(festivals);
        getFestivalsdata(festivals);
        // console.log(festivals);
      }
    });
  }
  getFestivals();
  function getFestivals(){
    alert('herer');
    $("#data").empty();
    magha_festivals();
    // phalguna_festivals();
    // chaitra_festivals();
    // vaishakha_festivals();
    // jyeshtha_festivals();
    // ashada_festivals();
    // shraavana_festivals();
    // bhadrapada_festivals();
    // ashvina_festivals();
    // kartika_festivals();
    // margashirsh_festivals();
    // pausha_festivals();
  }

  function magha_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/magha-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get magha festivals: ' + e);
    }
  }

  function phalguna_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/phalguna-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get phalguna festivals: ' + e);
    }
  }

  function chaitra_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/chaitra-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get chaitra festivals: ' + e);
    }
  }

  function vaishakha_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/vaishakha-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get vaishakha festivals: ' + e);
    }
  }

  function jyeshtha_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/jyeshtha-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get jyeshtha festivals: ' + e);
    }
  }

  function ashada_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/ashada-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get ashada festivals: ' + e);
    }
  }

  function shraavana_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/shraavana-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get shraavana festivals: ' + e);
    }
  }

  function bhadrapada_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/bhadrapada-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get bhadrapada festivals: ' + e);
    }
  }

  function ashvina_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/ashvina-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get ashvina festivals: ' + e);
    }
  }

  function kartika_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/kartika-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get kartika festivals: ' + e);
    }
  }

  function margashirsh_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/margashirsh-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get margashirsh festivals: ' + e);
    }
  }

  function pausha_festivals(){
    try {
      year = $('#year').val();
      month = $('#month').val();
      jQuery.ajax({
        // url: 'https://astroapi-3.divineapi.com/indian-api/v1/month-festivals',
        url: 'http://127.0.0.1:8000/indian-api/v1/pausha-festivals',
        method: 'post',
        headers: { "authorization": "Bearer " + access_token },
        async: false,
        data: { api_key: api_key, year: year, month: month, lat: lat, lon: lon, tzone: timezone, widget: true },
        beforeSend: function () {
          
        },
        complete: function () {
          
        },
        success: function (response) {
          var festivals = response.data.widget;
          getFestivalsdata(festivals);
          renderCalender(month, year);
        }
      });
    } catch (e) {
      console.log('Error in get pausha festivals: ' + e);
    }
  }

  function getFestivalsdata(festivals){
    for (const key in festivals) {
      let details_data = '';
      var data = festivals[key];
      if(typeof data.name !== 'undefined'){
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
      }else{
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

  function getFestivalsdata_old(festivals){
    var name = '';
    var date = '';
    var detail = '';
    
    for (const key in festivals) {
      name = '';
      date = '';
      detail = '';
      if (key.indexOf('_') !== -1) {
        name = key.charAt(0).toUpperCase() + key.slice(1).split("_").join(" ");
      } else {
        name = key.charAt(0).toUpperCase() + key.slice(1);
      }
      if(typeof festivals[key] == 'string'){
        date = festivals[key];
      }else if(typeof festivals[key] == 'object'){
        var data = findOjectData(festivals[key], name);
        // date = data.date;
        // detail = data.details;
        // console.log(data.date);
      }
      if (name == 'Indira ekadashi'){
        console.log(festivals[key]);
      }
      // var type = typeof festivals[key];
      // console.log(date + ' ' + name + ' ' +  'type' + ' ' + detail);

      festivalDataArray.push(
        {
          date: date, value: name, details: detail
        }
      );
    }
  }

  function findOjectData(festival, name){
    // console.log(festival.date);
    if(festival.date != 'undefined'){
      let detail_data = getOjectAllData(festival, name);
      console.log(name + ' '+ festival.date + ' ' + detail_data);
    }else{

    }
    // for (const key in festival) {
      
    // }
  }

  function getOjectAllData(festival, name){
    let detail_data = ''; 
    let key_name = '';
    for (const key in festival) {
      if(typeof festival[key] == 'string'){
        if (key.indexOf('_') !== -1) {
          key_name = key.charAt(0).toUpperCase() + key.slice(1).split("_").join(" ");
        } else {
          key_name = key.charAt(0).toUpperCase() + key.slice(1);
        }
        detail_data += "<p>" + key_name + ': ' + data[key] + '</p>';
      }else{
        // detail_data += getOjectAllData(festival, name);
      }
    }
    return detail_data;
  }

  function getOjectData(data, name){
    
    var response = [];
    var start_end = '';
    var key_name = ''; 
    var details = ''; 
    var temp_details = ''; 
    for (const key in data) {
      if(typeof data[key] == 'string'){
        if(key == 'date'){
          response['date'] = data[key];
        }else{
          if (key.indexOf('_') !== -1) {
            key_name = key.charAt(0).toUpperCase() + key.slice(1).split("_").join(" ");
          } else {
            key_name = key.charAt(0).toUpperCase() + key.slice(1);
          }
          details += "<p>" + key_name + ': ' + data[key] + '</p>';
        }
      // }else if (key.indexOf('ekadashi') !== -1){
        // var temp_data = getOjectData(data[key], name);
        // if(temp_data.date != 'undefined'){
        //   response['date'] = temp_data.date;
        // }
        // details += temp_data.details;
      }else if(typeof data[key] == 'object'){
        var temp_data = getOjectData2(data[key], name);
        if(temp_data.date != 'undefined'){
          response['date'] = temp_data.date;
        }
        response['key'] = temp_data.date;
        details += temp_data.details;
        // console.log(temp_data);
      }
      // console.log(name + ' ' );
      // console.log(data[key]);
    }
    response['details'] = details;
    if (name == 'Indira ekadashi'){
      console.log(response);
    }
    return response;
  }

  function festivalsdata(festivals) {

    festivalDataArray = [];
    for (const key in festivals) {

      if (key.indexOf('_') !== -1) {
        var keyval = key.charAt(0).toUpperCase() + key.slice(1).split("_").join(" ");
      } else {
        var keyval = key.charAt(0).toUpperCase() + key.slice(1);
      }

      var amavsya_details = '';
      var pitrupaksh_details = '';

      if (typeof festivals[key] === 'string' &&
        festivals[key] !== null) {
        festivalDataArray.push(
          {
            date: festivals[key], value: keyval
          }
        );
      } else {
        if (key.indexOf('ekadashi') !== -1) {
          if (typeof festivals[key] !== 'string') {
            if (festivals[key]['smartas'] && festivals[key]['vaishnavas']) {
              if (festivals[key]['smartas']['date'] == festivals[key]['vaishnavas']['date']) {
                if (festivals[key]['smartas']['parana']) {
                  var detail = "<p> smartas & vaishnavas </p> <p> parana: " + festivals[key]['smartas']['parana']['start_time'] + " to " + festivals[key]['smartas']['parana']['end_time'] + "</p>";
                } else {
                  var detail = "";
                }
                festivalDataArray.push(
                  {
                    date: festivals[key]['smartas']['date'], value: keyval, details: detail
                  }
                );
              } else {
                if (festivals[key]['smartas']['parana']) {
                  var detail = "<p> smartas </p> <p> parana: " + festivals[key]['smartas']['parana']['start_time'] + " to " + festivals[key]['smartas']['parana']['end_time'] + "</p>";
                } else {
                  var detail = "";
                }
                festivalDataArray.push(
                  {
                    date: festivals[key]['smartas']['date'], value: keyval, details: detail
                  }
                );
                if (festivals[key]['vaishnavas']['parana']) {
                  var detail = "<p> vaishnavas </p> <br><p> parana: " + festivals[key]['vaishnavas']['parana']['start_time'] + " to " + festivals[key]['vaishnavas']['parana']['end_time'] + "</p>";
                } else {
                  var detail = "";
                }
                festivalDataArray.push(
                  {
                    date: festivals[key]['vaishnavas']['date'], value: keyval, details: detail
                  }
                );
              }
            }


          }
        } else if (key.indexOf('pitru_paksha') !== -1) {
          for (const pitru_pakshaarr in festivals[key]) {
            var pitru_pakshaarr_details = '';
            var tithi = "<p>Tithi: " + festivals[key][pitru_pakshaarr]['tithi']['start_time'] + " to " + festivals[key][pitru_pakshaarr]['tithi']['end_time'] + "</p>";

            var kutup = "<p>Kutup: " + festivals[key][pitru_pakshaarr]['kutup']['start_time'] + " to " + festivals[key][pitru_pakshaarr]['kutup']['end_time'] + "</p>";

            var rohina = "<p>Rohina: " + festivals[key][pitru_pakshaarr]['rohina']['start_time'] + " to " + festivals[key][pitru_pakshaarr]['rohina']['end_time'] + "</p>";

            var aparahna = "<p>Aparahna: " + festivals[key][pitru_pakshaarr]['aparahna']['start_time'] + " to " + festivals[key][pitru_pakshaarr]['aparahna']['end_time'] + "</p>";

            festivalDataArray.push(
              {
                date: festivals[key][pitru_pakshaarr]['date'], value: 'Pitru Paksh', details: tithi + kutup + rohina + aparahna
              }
            );

          }
        }
        else {
          if (typeof festivals[key] === 'object' &&
            !Array.isArray(festivals[key]) &&
            festivals[key] !== null) {

            let key2isobject_date = '';
            for (const keyisobject in festivals[key]) {

              if (keyisobject.indexOf('start_time') !== -1) {
                festivalDataArray.push(
                  {
                    date: festivals[key][keyisobject], value: keyval + ' begins'
                  }
                );
              } else if (keyisobject.indexOf('end_time') !== -1) {
                festivalDataArray.push(
                  {
                    date: festivals[key][keyisobject], value: keyval + ' end'
                  }
                );
              } else if (keyisobject.indexOf('start_date') !== -1) {
                festivalDataArray.push(
                  {
                    date: festivals[key][keyisobject], value: keyval + ' begins'
                  }
                );
              } else if (keyisobject.indexOf('end_date') !== -1) {
                festivalDataArray.push(
                  {
                    date: festivals[key][keyisobject], value: keyval + ' end'
                  }
                );
              } else {

                if (keyisobject.indexOf('date') !== -1) {
                  key2isobject_date = festivals[key][keyisobject];
                }
                if (key2isobject_date && key2isobject_date != null && key2isobject_date != '') {

                  if (keyisobject.indexOf('auspicious_choghadiya') !== -1) {
                    var ganesh_visarjan = festivals[key].auspicious_choghadiya;

                    var detail = "";
                    for (const ganesh_visarjankey2 in ganesh_visarjan) {
                      if (ganesh_visarjan[ganesh_visarjankey2]) {
                        if (ganesh_visarjankey2.indexOf('_') !== -1) {
                          var ganesh_visarjankeyval2 = ganesh_visarjankey2.charAt(0).toUpperCase() + ganesh_visarjankey2.slice(1).replace("_", " ");
                        } else {
                          var ganesh_visarjankeyval2 = ganesh_visarjankey2.charAt(0).toUpperCase() + ganesh_visarjankey2.slice(1);
                        }
                        var detail = "<p>" + ganesh_visarjan[ganesh_visarjankey2]['choghadiya'] + ": " + ganesh_visarjan[ganesh_visarjankey2]['start_time'] + " to " + ganesh_visarjan[ganesh_visarjankey2]['end_time'] + "</p>";
                      }

                      festivalDataArray.push(
                        {
                          date: key2isobject_date, value: keyval, details: detail
                        }
                      );
                    }
                  } else if (typeof festivals[key][keyisobject] === 'object' &&
                    !Array.isArray(festivals[key][keyisobject]) &&
                    festivals[key][keyisobject] !== null) {
                    var detail = "";
                    if (keyisobject == 'tithi' || keyisobject == 'kutup' || keyisobject == 'rohina' || keyisobject == 'aparahna') {
                      if (keyisobject.indexOf('_') !== -1) {
                        var keyval2 = keyisobject.charAt(0).toUpperCase() + keyisobject.slice(1).replace("_", " ");
                      } else {
                        var keyval2 = keyisobject.charAt(0).toUpperCase() + keyisobject.slice(1);
                      }
                      detail = "<p>" + keyval2 + ": " + festivals[key][keyisobject]['start_time'] + " to " + festivals[key][keyisobject]['end_time'] + "</p>";
                      amavsya_details += detail;
                      // amavsya_details.push({details:detail});
                      // festivalDataArray.push(
                      //   {
                      //     date: key2isobject_date, value: keyval,details:detail
                      //   }
                      // );
                    } else {

                      for (const key2isobject in festivals[key][keyisobject]) {
                        if (key2isobject.indexOf('start_time') !== -1) {
                          if (festivals[key][keyisobject][key2isobject]) {
                            if (keyisobject.indexOf('_') !== -1) {
                              var keyval2 = keyisobject.charAt(0).toUpperCase() + keyisobject.slice(1).replace("_", " ");
                            } else {
                              var keyval2 = keyisobject.charAt(0).toUpperCase() + keyisobject.slice(1);
                            }
                            var detail = "<p>" + keyval2 + ": " + festivals[key][keyisobject]['start_time'] + " to " + festivals[key][keyisobject]['end_time'] + "</p>";
                          }
                          festivalDataArray.push(
                            {
                              date: key2isobject_date, value: keyval, details: detail
                            }
                          );
                        } else if (typeof festivals[key][keyisobject][key2isobject] === 'object' &&
                          !Array.isArray(festivals[key][keyisobject][key2isobject]) &&
                          festivals[key][keyisobject][key2isobject] !== null) {

                          var detail = "";
                          for (const key3isobject in festivals[key][keyisobject][key2isobject]) {

                            if (key3isobject.indexOf('start_time') !== -1) {
                              if (festivals[key][keyisobject][key2isobject][key3isobject]) {
                                if (key2isobject.indexOf('_') !== -1) {
                                  var keyval3 = key2isobject.charAt(0).toUpperCase() + key2isobject.slice(1).replace("_", " ");
                                } else {
                                  var keyval3 = key2isobject.charAt(0).toUpperCase() + key2isobject.slice(1);
                                }
                                detail += "<p>" + keyval3 + ": " + festivals[key][keyisobject][key2isobject]['start_time'] + " to " + festivals[key][keyisobject][key2isobject]['end_time'] + "</p>";
                              }
                              // festivalDataArray.push(
                              //   {
                              //     date: key2isobject_date, value: keyval,details:detail
                              //   }
                              // );
                            }
                          }
                          festivalDataArray.push(
                            {
                              date: key2isobject_date, value: keyval, details: detail
                            }
                          );
                        }
                      }
                    }
                  }
                } else {
                  festivalDataArray.push(
                    {
                      date: festivals[key][keyisobject], value: keyval
                    }
                  );
                }
              }

              // else if(keyisobject.indexOf('date') !== -1){
              //   festivalDataArray.push(
              //     {
              //       date: festivals[key][keyisobject], value: keyval
              //     }
              //   );
              // }
            }
            if (amavsya_details != '') {
              festivalDataArray.push(
                {
                  date: key2isobject_date, value: keyval, details: amavsya_details
                }
              );
            }
          }
        }
      }
    }

    // console.log(festivalDataArray);
    // console.log(month + year);
    renderCalender(month, year);
  }

  function isLocalhost(url) {
    return url.includes('localhost') || url.includes('127.0.0.1');
  }

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

  //End Location

  $(document).on("click", ".fapidate", function () {

    // alert(data);
    var text = $(this).contents().filter(function () {
      return this.nodeType === 3;
    }).text().trim();
    var dates = `${$("#year").children("option:selected").val()}-${$("#months")
      .children("option:selected")
      .val()}-${text}`;
    var data = showData(dates);
    $("#data").empty();
    $("#data").append(data);
  });
  //   function showData(data){
  //     foreach(data as data){

  //     }
  //   }
})(jQuery);