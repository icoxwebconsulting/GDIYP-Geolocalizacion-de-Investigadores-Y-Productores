"use strict";
var $ = jQuery.noConflict();

var mapStyles = [ {"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"},{"lightness":20}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"on"},{"lightness":10}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":50}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#a1cdfc"},{"saturation":30},{"lightness":49}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#f49935"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#fad959"}]}, {featureType:'road.highway',elementType:'all',stylers:[{hue:'#dddbd7'},{saturation:-92},{lightness:60},{visibility:'on'}]}, {featureType:'landscape.natural',elementType:'all',stylers:[{hue:'#c8c6c3'},{saturation:-71},{lightness:-18},{visibility:'on'}]},  {featureType:'poi',elementType:'all',stylers:[{hue:'#d9d5cd'},{saturation:-70},{lightness:20},{visibility:'on'}]} ];

// Set map height to 100% ----------------------------------------------------------------------------------------------

var $body = $('body');
if( $body.hasClass('map-fullscreen') ) {
    if( $(window).width() > 768 ) {
        $('.map-canvas').height( $(window).height() - $('.header').height() );
    }
    else {
        $('.map-canvas #map').height( $(window).height() - $('.header').height() );
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Homepage map - Google
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function createHomepageGoogleMap(_latitude,_longitude,json){
    $.get("/assets/spotter/external/_infobox.js", function() {
        gMap();
    });
    function gMap(){
        var mapCenter = new google.maps.LatLng(_latitude,_longitude);
        var mapOptions = {
            zoom: 2,
            center: mapCenter,
            disableDefaultUI: false,
            scrollwheel: false,
            styles: mapStyles,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.BOTTOM_CENTER
            },
            panControl: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_TOP
            }
        };
        var mapElement = document.getElementById('map');
        var map = new google.maps.Map(mapElement, mapOptions);
        var newMarkers = [];
        var markerClicked = 0;
        var activeMarker = false;
        var lastClicked = false;
        var color;

        for (var i = 0; i < json.length; i++) {

            // Google map marker content -----------------------------------------------------------------------------------
            if( json[i].user.roles.includes("ROLE_INVESTIGATOR")){
                // console.log('role investigator', json[i].user.roles);
                color = 'red';
            }else if( json[i].user.roles.includes("ROLE_PRODUCER")){
                // console.log('role producer', json[i].user.roles);
                color = 'blue';
            }
            // if( json[i].color ) var color = json[i].color;
            // else color = '';

            var markerContent = document.createElement('DIV');
            if( json[i].featured == 1 ) {
                markerContent.innerHTML =
                    '<div class="map-marker featured' + color + '">' +
                        '<div class="icon">' +
                        // '<img src="' + json[i].type_icon +  '">' +
                        '</div>' +
                    '</div>';
            }
            else {
                markerContent.innerHTML =
                    '<div class="map-marker ' + color + '">' +
                        '<div class="icon">' +
                        // '<img src="' + json[i].type_icon +  '">' +
                        '</div>' +
                    '</div>';
            }

            // Create marker on the map ------------------------------------------------------------------------------------

            var marker = new RichMarker({
                position: new google.maps.LatLng( json[i].address.latitude, json[i].address.longitude ),
                map: map,
                draggable: false,
                content: markerContent,
                flat: true
            });

            newMarkers.push(marker);

            // Create infobox for marker -----------------------------------------------------------------------------------

            var infoboxContent = document.createElement("div");
            var infoboxOptions = {
                content: infoboxContent,
                disableAutoPan: false,
                pixelOffset: new google.maps.Size(-18, -42),
                zIndex: null,
                alignBottom: true,
                boxClass: "infobox",
                enableEventPropagation: true,
                closeBoxMargin: "0px 0px -30px 0px",
                closeBoxURL: "/assets/spotter/img/close.png",
                infoBoxClearance: new google.maps.Size(1, 1)
            };

            // Infobox HTML element ----------------------------------------------------------------------------------------

            // var category = json[i].category;
            var url = Routing.generate('homepage_user_show', {
                'id': json[i].user.id
            });
            infoboxContent.innerHTML = drawInfobox(url, infoboxContent, json, i);

            // Create new markers ------------------------------------------------------------------------------------------

            newMarkers[i].infobox = new InfoBox(infoboxOptions);

            // Show infobox after click ------------------------------------------------------------------------------------

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    google.maps.event.addListener(map, 'click', function(event) {
                        lastClicked = newMarkers[i];
                    });
                    activeMarker = newMarkers[i];
                    if( activeMarker != lastClicked ){
                        for (var h = 0; h < newMarkers.length; h++) {
                            newMarkers[h].content.className = 'marker-loaded';
                            newMarkers[h].infobox.close();
                        }
                        newMarkers[i].infobox.open(map, this);
                        newMarkers[i].infobox.setOptions({ boxClass:'fade-in-marker'});
                        newMarkers[i].content.className = 'marker-active marker-loaded';
                        markerClicked = 1;
                        console.log('newmarkers',newMarkers);
                    }
                }
            })(marker, i));

            // Fade infobox after close is clicked -------------------------------------------------------------------------

            google.maps.event.addListener(newMarkers[i].infobox, 'closeclick', (function(marker, i) {
                return function() {
                    activeMarker = 0;
                    newMarkers[i].content.className = 'marker-loaded';
                    newMarkers[i].infobox.setOptions({ boxClass:'fade-out-marker' });
                }
            })(marker, i));
        }

        // Close infobox after click on map --------------------------------------------------------------------------------

        google.maps.event.addListener(map, 'click', function(event) {
            if( activeMarker != false && lastClicked != false ){
                if( markerClicked == 1 ){
                    activeMarker.infobox.open(map);
                    activeMarker.infobox.setOptions({ boxClass:'fade-in-marker'});
                    activeMarker.content.className = 'marker-active marker-loaded';
                }
                else {
                    markerClicked = 0;
                    activeMarker.infobox.setOptions({ boxClass:'fade-out-marker' });
                    activeMarker.content.className = 'marker-loaded';
                    setTimeout(function() {
                        activeMarker.infobox.close();
                    }, 350);
                }
                markerClicked = 0;
            }
            if( activeMarker != false ){
                google.maps.event.addListener(activeMarker, 'click', function(event) {
                    markerClicked = 1;
                });
            }
            markerClicked = 0;
        });

        // Create marker clusterer -----------------------------------------------------------------------------------------

        var clusterStyles = [
            {
                url: '/assets/spotter/img/cluster.png',
                height: 34,
                width: 34
            }
        ];

        var markerCluster = new MarkerClusterer(map, newMarkers, { styles: clusterStyles, maxZoom: 19 });
        markerCluster.onClick = function(clickedClusterIcon, sameLatitude, sameLongitude) {
            return multiChoice(sameLatitude, sameLongitude, json);
        };

        // Dynamic loading markers and data from JSON ----------------------------------------------------------------------

        google.maps.event.addListener(map, 'idle', function() {
            var visibleArray = [];
            for (var i = 0; i < json.length; i++) {
                if ( map.getBounds().contains(newMarkers[i].getPosition()) ){
                    visibleArray.push(newMarkers[i]);
                    $.each( visibleArray, function (i) {
                        setTimeout(function(){
                            if ( map.getBounds().contains(visibleArray[i].getPosition()) ){
                                if( !visibleArray[i].content.className ){
                                    visibleArray[i].setMap(map);
                                    visibleArray[i].content.className += 'bounce-animation marker-loaded';
                                    markerCluster.repaint();
                                }
                            }
                        }, i * 50);
                    });
                } else {
                    newMarkers[i].content.className = '';
                    newMarkers[i].setMap(null);
                }
            }

            var visibleItemsArray = [];
            $.each(json, function(a) {
                if( map.getBounds().contains( new google.maps.LatLng( json[a].address.latitude, json[a].address.longitude ) ) ) {
                    var category = json[a].category;
                    pushItemsToArray(json, a, category, visibleItemsArray);
                }
            });

            // Create list of items in Results sidebar ---------------------------------------------------------------------

            $('.items-list .results').html( visibleItemsArray );

            // Check if images are cached, so will not be loaded again

            $.each(json, function(a) {
                if( map.getBounds().contains( new google.maps.LatLng( json[a].address.latitude, json[a].address.longitude ) ) ) {
                    // is_cached(json.data[a].gallery[0], a);
                }
            });

            // Call Rating function ----------------------------------------------------------------------------------------

            rating('.results .item');

            var $singleItem = $('.results .item');
            $singleItem.hover(
                function(){
                    newMarkers[ $(this).attr('id') - 1 ].content.className = 'marker-active marker-loaded';
                },
                function() {
                    newMarkers[ $(this).attr('id') - 1 ].content.className = 'marker-loaded';
                }
            );
        });

        redrawMap('google', map);

        function is_cached(src, a) {
            var image = new Image();
            var loadedImage = $('.results li #' + json.data[a].id + ' .image');
            image.src = src;
            if( image.complete ){
                $(".results").each(function() {
                    loadedImage.removeClass('loading');
                    loadedImage.addClass('loaded');
                });
            }
            else {
                $(".results").each(function() {
                    $('.results li #' + json[a].id + ' .image').addClass('loading');
                });
                $(image).load(function(){
                    loadedImage.removeClass('loading');
                    loadedImage.addClass('loaded');
                });
            }
        }

        // Geolocation of user -----------------------------------------------------------------------------------------

        $('.geolocation').on("click", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success);
            } else {
                console.log('Geo Location is not supported');
            }
        });

        function success(position) {
            var locationCenter = new google.maps.LatLng( position.coords.latitude, position.coords.longitude);
            map.setCenter( locationCenter );
            map.setZoom(14);
			
			var markerContent = document.createElement('DIV');
			markerContent.innerHTML =
				'<div class="map-marker">' +
					'<div class="icon">' +
					'</div>' +
				'</div>';

			// Create marker on the map ------------------------------------------------------------------------------------

			var marker = new RichMarker({
				position: locationCenter,
				map: map,
				draggable: false,
				content: markerContent,
				flat: true
			});

			marker.content.className = 'marker-loaded';

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                "latLng": locationCenter
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var lat = results[0].geometry.location.lat(),
                        lng = results[0].geometry.location.lng(),
                        placeName = results[0].address_components[0].long_name,
                        latlng = new google.maps.LatLng(lat, lng);

                    $("#location").val(results[0].formatted_address);
                }
            });

        }

        // Autocomplete address ----------------------------------------------------------------------------------------

        var input = document.getElementById('location') ;
        var autocomplete = new google.maps.places.Autocomplete(input, {
            types: ["geocode"]
        });
        autocomplete.bindTo('bounds', map);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
                map.setZoom(14);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(14);
            }

            //marker.setPosition(place.geometry.location);
            //marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
        });


    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// OpenStreetMap - Homepage
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function createHomepageOSM(_latitude,_longitude,json,mapProvider){
    var url = "{{assets('assets/spotter/external/_infobox.js')}}";
    $.get(url, function() {
        osmMap();
    });

    function osmMap(){
        var map = L.map('map', {
                center: [_latitude,_longitude],
                zoom: 14,
                scrollWheelZoom: false
        });

        L.tileLayer.provider(mapProvider).addTo(map);

        var markers = L.markerClusterGroup({
            showCoverageOnHover: false,
            zoomToBoundsOnClick: false
        });

        var loadedMarkers = [];

        // Create markers on the map -----------------------------------------------------------------------------------

        for (var i = 0; i < json.length; i++) {

            // Set icon for marker -------------------------------------------------------------------------------------

            if( json[i].type_icon ) var icon = '<img src="' + json[i].type_icon +  '">';
            else icon = '';

            if( json[i].color ) var color = json[i].color;
            else color = '';

            var markerContent =
                '<div class="map-marker ' + json[i].user.roles + '">' +
                    '<div class="icon">' +
                    icon +
                    '</div>' +
                '</div>';

            var _icon = L.divIcon({
                html: markerContent,
                iconSize:     [36, 46],
                iconAnchor:   [18, 32],
                popupAnchor:  [130, -28],
                className: ''
            });

            var title = json[i].title;
            var marker = L.marker(new L.LatLng( json[i].latitude, json[i].longitude ), {
                title: title,
                icon: _icon
            });

            loadedMarkers.push(marker);

            // Infobox HTML element ------------------------------------------------------------------------------------

            var category = json[i].category;
            var infoboxContent = document.createElement("div");
            marker.bindPopup(
                drawInfobox(category, infoboxContent, json, i)
            );
            markers.addLayer(marker);

            // Set hover states for marker -----------------------------------------------------------------------------

            marker.on('popupopen', function () {
                this._icon.className += ' marker-active';
            });
            marker.on('popupclose', function () {
                this._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
            });

        }

        map.addLayer(markers);

        // Animate already created markers -----------------------------------------------------------------------------

        animateOSMMarkers(map, loadedMarkers, json);
        map.on('moveend', function() {
            animateOSMMarkers(map, loadedMarkers, json);
        });

        markers.on('clusterclick', function (a) {

            var markersInCLuster = a.layer.getAllChildMarkers();
            var latitudeArray = [];
            var longitudeArray = [];

            for (var b=0; b < markersInCLuster.length; b++)
            {
                var formattedLatitude = parseFloat( markersInCLuster[b]._latlng.lat ).toFixed(6);
                var formattedLongitude = parseFloat( markersInCLuster[b]._latlng.lng ).toFixed(6);
                latitudeArray.push( formattedLatitude );
                longitudeArray.push( formattedLongitude );
            }

            Array.prototype.allValuesSame = function() {
                for(var i = 1; i < this.length; i++)
                {
                    if(this[i] !== this[0])
                        return false;
                }
                return true;
            };

            if( latitudeArray.allValuesSame() && longitudeArray.allValuesSame() ){
                multiChoice(latitudeArray[0], longitudeArray[0], json);
            }
            else {
                a.layer.zoomToBounds();
            }
        });

        $('.results .item').hover(
            function(){
                loadedMarkers[ $(this).attr('id') - 1 ]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded marker-active';
            },
            function() {
                loadedMarkers[ $(this).attr('id') - 1 ]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
            }
        );

        $('.geolocation').on("click", function() {
            map.locate({setView : true})
        });

        $('body').addClass('loaded');
        setTimeout(function() {
            $('body').removeClass('has-fullscreen-map');
        }, 1000);
        $('#map').removeClass('fade-map');

        redrawMap('osm', map);
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Item Detail Map - Google
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function itemDetailMap(json){
    var mapCenter = new google.maps.LatLng(json.latitude,json.longitude);
    var mapOptions = {
        zoom: 4,
        center: mapCenter,
        disableDefaultUI: true,
        scrollwheel: false,
        styles: mapStyles,
        panControl: false,
        zoomControl: true,
        draggable: true
    };
    var mapElement = document.getElementById('map-detail');
    var map = new google.maps.Map(mapElement, mapOptions);
    if( json.type_icon ) var icon = '<img src="' + json.type_icon +  '">';
    else icon = '';

    // Google map marker content -----------------------------------------------------------------------------------

    var markerContent = document.createElement('DIV');
    markerContent.innerHTML =
        '<div class="map-marker">' +
            '<div class="icon">' +
            // icon +
            '</div>' +
        '</div>';

    // Create marker on the map ------------------------------------------------------------------------------------
    var marker = new RichMarker({
        position: new google.maps.LatLng( json.latitude, json.longitude ),
        map: map,
        draggable: false,
        content: markerContent,
        flat: true
    });

    marker.content.className = 'marker-loaded';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Simple Google Map (contat, submit...)
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function simpleMap(_latitude, _longitude, draggableMarker){
    //console.log(_latitude,_longitude,draggableMarker );
    var mapCenter = new google.maps.LatLng(_latitude, _longitude);
    var mapOptions = {
        zoom: 14,
        center: mapCenter,
        disableDefaultUI: true,
        scrollwheel: false,
        styles: mapStyles,
        panControl: false,
        zoomControl: false,
        draggable: true
    };
    var mapElement = document.getElementById('map-simple');
    var map = new google.maps.Map(mapElement, mapOptions);

    // Google map marker content -----------------------------------------------------------------------------------

    var markerContent = document.createElement('DIV');
    markerContent.innerHTML =
        '<div class="map-marker">' +
            '<div class="icon"></div>' +
        '</div>';

    // Create marker on the map ------------------------------------------------------------------------------------

    var marker = new RichMarker({
        //position: mapCenter,
        position: new google.maps.LatLng( _latitude, _longitude ),
        map: map,
        draggable: draggableMarker,
        content: markerContent,
        flat: true
    });

    marker.content.className = 'marker-loaded';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Push items to array and create <li> element in Results sidebar ------------------------------------------------------

function pushItemsToArray(json, a, category, visibleItemsArray){
    var itemPrice;
    var url = Routing.generate('homepage_user_show', {
        'id': json[a].user.id
    });
    visibleItemsArray.push(
        '<li>' +
            '<div class="item">' +
                '<a href="' + url +'" class="image">' +
                    '<div class="inner">' +
                    '<img src="../uploads/user/profile/'+json[a].user.imageName+'" alt="">'+
                        '<div class="item-specific">' +
                            // drawItemSpecific(category, json, a) +
                        '</div>' +
                        // '<img src="' + json[a].gallery[0] + '" alt="">' +
                    '</div>' +
                '</a>' +
                '<div class="wrapper">' +
                    '<a href="' + url + '"><h4>' + json[a].user.firstName + ' '+ json[a].user.lastName +'</h4></a>' +
                    '<figure>' + json[a].address.address + '</figure>' +
                    // drawPrice(json[a].price) +
                    // drawPrice(json[a].price) +
                    '<div class="price"><a href="' + url + '">ver</a></div>' +
                    // '<div class="info">' +
                    //     '<div class="type">' +
                    //         '<i><img src="' + json[a].type_icon + '" alt=""></i>' +
                    //         '<span>' + json[a].type + '</span>' +
                    //     '</div>' +
                    //     '<div class="rating" data-rating="' + json[a].rating + '"></div>' +
                    // '</div>' +
                '</div>' +
            '</div>' +
        '</li>'
    );

    function drawPrice(price){
        if( price ){
            itemPrice = '<div class="price">' + price +  '</div>';
            return itemPrice;
        }
        else {
            return '';
        }
    }
}

// Center map to marker position if function is called (disabled) ------------------------------------------------------

function centerMapToMarker(){
    $.each(json, function(a) {
        if( json[a].id == id ) {
            var _latitude = json[a].latitude;
            var _longitude = json[a].longitude;
            var mapCenter = new google.maps.LatLng(_latitude,_longitude);
            map.setCenter(mapCenter);
        }
    });
}

// Create modal if more items are on the same location (example: one building with floors) -----------------------------

function multiChoice(sameLatitude, sameLongitude, json) {
    //if (clickedCluster.getMarkers().length > 1){
        sameLatitude = parseFloat(sameLatitude).toFixed(6);
        sameLongitude = parseFloat(sameLongitude).toFixed(6);
        var latitude;
        var longitude;
        var multipleItems = [];
        $.each(json, function(a) {
            latitude = parseFloat(json[a].address.latitude).toFixed(6);
            longitude = parseFloat(json[a].address.longitude).toFixed(6);
            if( latitude == sameLatitude && longitude == sameLongitude ) {
                pushItemsToArray(json, a, json[a].category, multipleItems);
            }
        });
        $('body').append('<div class="modal-window multichoice fade_in"></div>');
        $('.modal-window').load( '/assets/spotter/external/_modal-multichoice.html', function() {
            $('.modal-window .modal-wrapper .items').html( multipleItems );
            rating('.modal-window');
        });
        $('.modal-window .modal-background, .modal-close').live('click',  function(e){
            $('.modal-window').addClass('fade_out');
            setTimeout(function() {
                $('.modal-window').remove();
            }, 300);
        });
    //}
}

// Animate OSM marker --------------------------------------------------------------------------------------------------

function animateOSMMarkers(map, loadedMarkers, json){
    var bounds = map.getBounds();
    var visibleItemsArray = [];
    var multipleItems = [];

    $.each( loadedMarkers, function (i) {
        if ( bounds.contains( loadedMarkers[i].getLatLng() ) ) {
            var category = json[i].category;
            pushItemsToArray(json, i, category, visibleItemsArray);

            setTimeout(function(){
                if( loadedMarkers[i]._icon != null ){
                    loadedMarkers[i]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
                }
            }, i* 50);
        }
        else {
            if( loadedMarkers[i]._icon != null ){
                loadedMarkers[i]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable';
            }
        }
    });

    // Create list of items in Results sidebar -------------------------------------------------------------------------

    $('.items-list .results').html( visibleItemsArray );

    rating('.results .item');

    $('.results .item').hover(
        function(){
            if( loadedMarkers[ $(this).attr('id') - 1 ]._icon ){
                loadedMarkers[ $(this).attr('id') - 1 ]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded marker-active';
            }
        },
        function() {
            if( loadedMarkers[ $(this).attr('id') - 1 ]._icon ){
                loadedMarkers[ $(this).attr('id') - 1 ]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
            }
        }
    );

}

// Redraw map after item list is closed --------------------------------------------------------------------------------

function redrawMap(mapProvider, map){
    $('.map .toggle-navigation').click(function() {
        $('.map-canvas').toggleClass('results-collapsed');
        $('.map-canvas .map').one("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
            if( mapProvider == 'osm' ){
                map.invalidateSize();
            }
            else if( mapProvider == 'google' ){
                google.maps.event.trigger(map, 'resize');
            }
        });
    });
}