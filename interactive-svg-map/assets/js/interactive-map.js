jQuery(document).ready(function () {


    var zoomMap = (interactivemap.map_zoom === "true");
    var multiselect = (interactivemap.map_multiselect === "true");
    var labelMap = (interactivemap.map_labels === "true");
    var mapToolTip = (interactivemap.map_tooltip === "true");

    /**
     * Initialize Map
     */
    jQuery('#vmap').vectorMap({
        map: interactivemap.map + "_en",
        backgroundColor: interactivemap.map_background_color,
        borderColor: interactivemap.map_border_color,
        borderOpacity: interactivemap.map_border_opacity,
        borderWidth: interactivemap.map_border_width,
        color: interactivemap.map_color,
        enableZoom: zoomMap,
        hoverColor: interactivemap.map_region_hover_color,
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: interactivemap.map_selected_color,
        selectedRegions: null,
        showTooltip: mapToolTip,
        //showLabels: labelMap,
        multiSelectRegion: multiselect,
    });
});