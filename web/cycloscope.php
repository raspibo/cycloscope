<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Cycloscope project track</title>

<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
<script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet' />

<style>
  body { margin:0; padding:0; }
  #map { position:absolute; top:0; bottom:0; width:100%; }
</style>
</head>
<body>

<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.0.1/leaflet-omnivore.min.js'></script>
<div id='map'>
</div>

<div id='legend-content' style='display: none;'>
  <div class='my-legend'>
  <div class='legend-title'><a href="http://cycloscope.weebly.com/" target=_top>Cycloscope</a>
</div>
  <div class='legend-scale'>
    <ul class='legend-labels'>
      <li>A <a href="http://cycloscope.weebly.com/path.html" title="">bicycle journey</a>&nbsp;through central Asia</li>
      <li>A series of reportage</li>
      <li>A new approach to&nbsp;<a href="http://cycloscope.weebly.com/1/post/2014/04/automatic-road-sampler.html" target="_blank" title="">world mapping</a></li>
    </ul>
  </div>
  </div>

  <style type='text/css'>
    .map-legends .map-legend {
      background-color: rgb(255, 208, 24);
    }
    .my-legend .legend-title {
      font-family: "Vanilla" !important;
      margin-bottom: 8px;
      font-weight: bold;
      font-size: 90%;
      }
    .my-legend .legend-scale ul {
      background-color: rgb(255, 208, 24);
      margin: 0;
      padding: 0;
      height: 10%;
      }
    .my-legend .legend-scale ul li {
      background-color: rgb(255, 208, 24);
      margin-bottom: 6px;
      margin-left: 6px;
      font-family: "Trebuchet MS" !important;
      font-size: 80%;
      }
    .my-legend ul.legend-labels li span {
      height: 15px;
      }
    .my-legend .legend-source {
      font-size: 70%;
      color: #999;
      clear: both;
      }
    .my-legend a {
      color: #777;
      }
  </style>
</div>

<script>
var map = L.mapbox.map('map', 'examples.map-i86nkdio');
//var map = L.map('map', {
//      center: [51.505, -0.09],
//zoom: 13
//});
//var map = L.mapbox.map('map', 'dancast78.i8iac47o').addControl(L.mapbox.geocoderControl('dancast78.i8iac47o'));
map.legendControl.addLegend(document.getElementById('legend-content').innerHTML);
// omnivore will AJAX-request this file behind the scenes and parse it:
// note that there are considerations:
// - The file must either be on the same domain as the page that requests it,
//   or both the server it is requested from and the user's browser must
//   support CORS.
var runLayer = omnivore.gpx('cycloscope.gpx')
    .on('ready', function() {
        map.fitBounds(runLayer.getBounds());
    })
    .addTo(map);
omnivore.csv('markers.csv')
    .on('ready', function(layer) {
        // An example of customizing marker styles based on an attribute.
        // In this case, the data, a CSV file, has a column called 'state'
        // with values referring to states. Your data might have different
        // values, so adjust to fit.
        this.eachLayer(function(marker) {
            if (marker.toGeoJSON().properties.state === 'IT') {
                // The argument to L.mapbox.marker.icon is based on the
                // simplestyle-spec: see that specification for a full
                // description of options.
                marker.setIcon(L.mapbox.marker.icon({
                    'marker-color': '#55ff55',
                    'marker-size': 'small',
                    'marker-symbol': 'bicycle'
                }));
            } else {
                marker.setIcon(L.mapbox.marker.icon({'marker-color': '#55ff55','marker-size': 'small', 'marker-symbol': 'bicycle'}));
            }
            // Bind a popup to each icon based on the same properties
/*            marker.bindPopup(marker.toGeoJSON().properties.city + ', ' +
                marker.toGeoJSON().properties.state);
*/
            marker.bindPopup(marker.toGeoJSON().properties.city);
        });
        map.fitBounds(this.getBounds());
    })
.addTo(map);

// the function given to this callback will be called every time the map
// completes a zoom animation.
map.on('zoomend', function() {
    // here's where you decided what zoom levels the layer should and should
    // not be available for: use javascript comparisons like < and > if
    // you want something other than just one zoom level, like
    // (map.getZoom > 10)
    if (map.getZoom() > 13) {
        // setFilter is available on L.mapbox.featureLayers only. Here
        // we're hiding and showing the default marker layer that's attached
        // to the map - change the reference if you want to hide or show a
        // different featureLayer.
        // If you want to hide or show a different kind of layer, you can use
        // similar methods like .setOpacity(0) and .setOpacity(1)
        // to hide or show it.
        map.featureLayer.setFilter(function() { return true; });
    } else {
        map.featureLayer.setFilter(function() { return false; });
    }
});
</script>
</body>
</html>
