
(function($) {
    "use strict";

    function isGoogleMapsLoaded() {
        console.log(typeof google !== 'undefined' && typeof google.maps !== 'undefined');
        return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    }

    $(document).ready(function(){

        if (isGoogleMapsLoaded()) {
            // console.log('already loaded 123');
        } else {
            // console.log('not loaded 123');
            $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
                if (typeof initMap === 'function') {
                    initMap();
                }
                if (typeof initMapInaus === 'function') {
                    initMapInaus();
                }
                if (typeof initMapChoghadiya === 'function') {
                    initMapChoghadiya();
                }
                if (typeof initMapNakshatra === 'function') {
                    initMapNakshatra();
                }
                if (typeof initMapSM === 'function') {
                    initMapSM();
                }
                if (typeof initMapPanchang === 'function') {
                    initMapPanchang();
                }
                if (typeof initMapSamvat === 'function') {
                    initMapSamvat();
                }
                if (typeof initMapAyana === 'function') {
                    initMapAyana();
                }
                if (typeof initMapAuspi === 'function') {
                    initMapAuspi();
                }
                if (typeof initMapShool === 'function') {
                    initMapShool();
                }
                if (typeof initMapEpoch === 'function') {
                    initMapEpoch();
                }
                if (typeof initMapChandra === 'function') {
                    initMapChandra();
                }
                if (typeof initMapUdaya === 'function') {
                    initMapUdaya();
                }
                if (typeof initMapUdaya === 'function') {
                    initMapUdaya();
                }
                if (typeof initMapFestivals === 'function') {
                    initMapFestivals();
                }
                if (typeof kundaliMng != 'undefined' && typeof kundaliMng.initmap === 'function') {
                    kundaliMng.initmap();
                }
                if (typeof kundaliMatchingMng != 'undefined' && typeof kundaliMatchingMng.initmap === 'function') {
                    kundaliMatchingMng.initmap();
                }
            });
        }

    });

})(jQuery);