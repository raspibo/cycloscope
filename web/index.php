<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Cycloscope - two 2-wheeled storytellers a cycle of cycles </title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js'></script>
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css' rel='stylesheet' />
<style>
#bg {
  position: fixed; 
  top: 0; 
  left: 0; 
	
  /* Preserve aspet ratio */
  min-width: 100%;
  min-height: 100%;
  
  max-height: 100%;
  z-index: 5;
}

#icontenitore {
  position: fixed;
  z-index:7;
  margin: auto;
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
  width:100%; height:100%;
  text-align:center;
  min-height: 10em;
  display: table-cell;
  vertical-align: middle
}

#presentation {
  position: fixed;
  z-index:7;
  margin: auto;
  top: 0; left: 0; bottom: 0; right: 0;
  width:80%; height:80%;
  text-align:center;
  min-height: 10em;
  display: table-cell;
  vertical-align: middle;
  background: rgba(225, 225, 225, .8);
  border-radius: 25px;
  color: #000000;
  border: 2px outset;
  padding: 3%;
}

#button {
  position: relative;
  z-index:7;
  margin: auto;
  text-align:center;
  vertical-align:middle;
  min-height: 1em;
  background: rgba(0, 0, 255, 1);
  border-radius: 20px;
  color: #ffffff;
  font-weight: 900;
  white-space:nowrap;
  padding: 1%;
  width: 60%;
}

#button:hover
{
  background-color:yellow;
  color: #000000;
  cursor: pointer; cursor: hand;
} 

 body { margin:0; padding:0; 
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    color: #797979;
    margin: 0px;
    padding: 16px 0px 0px;
}
#map { position:absolute; top:0; bottom:0; width:100%; }

pre.ui-coordinates {
 position:absolute;
 bottom:10px;
 left:10px;
 padding:5px 10px;
 background:rgba(0,0,0,0.5);
 color:#fff;
 font-size:11px;
 line-height:18px;
 border-radius:3px;
 }

article {
 position:absolute;
 top:0;
 right:0;
 bottom:22%;
 left:0;
 overflow:auto;
 font-family: "Trebuchet MS" !important;
 }
.quiet {
 color:rgba(0,0,0,1);
 font-weight: 1000;
 }
.scroll {
 display:block;
 text-align:center;
 }
.sections {
 background:rgba(255,255,255,0.5);
 width:40%;
 }
section {
 padding:5px;
 color:rgba(0,0,0,0.5);
 -webkit-transition:background 500ms, color 500ms;
         transition:background 500ms, color 500ms;
 }
section.active {
 background:#FFD018;
 color:#404040;
 }


gallery {
 position:absolute;
 top:78%;
 right:0;
 bottom:0px;
 left:0;
 overflow:auto;
 font-family: "Trebuchet MS" !important;
 }

#wsite-title {
    font-family: "Vanilla" !important;
    font-size: 4em !important;
}
#elenco{
  text-align:left;
  padding-left: 35%;
}
</style>
<script>
function nascondi_foto() {
 document.getElementById('bg').style.zIndex=-5;
// document.getElementById('contenitore').style.zIndex=-5;
 document.getElementById('presentation').style.zIndex=-5;
 document.getElementById('button').style.zIndex=-5;
var x=0;

var interval=window.setInterval(function() {
Layers[x].addTo(map);
x++;
if (x >= Layers.length) {
window.clearInterval(interval);
}
}, 300);



}
</script>
<img src="photo/cycloscope_bg.jpg" id="bg" alt="">
<div id=presentation>
<span id="wsite-title"  onclick="nascondi_foto()">Cycloscope</span>
<div id=button onclick="nascondi_foto()">
Visualizza il nostro diario
</div>
<img src=photo/Cycloscope.png style="display: inline-table;"  onclick="nascondi_foto()">
</div>
<div id='map'></div>
<pre id='coordinates' class='ui-coordinates'></pre>
<script>
var map = L.mapbox.map('map', 'dancast78.i8iac47o')
  .setView([44.5, 21.7], 4);


var coordinates = document.getElementById('coordinates');

/*
var marker = L.marker([44.5, 21.7], {
   icon: L.mapbox.marker.icon({
     'marker-color': '#404040'
   }),
   draggable: true
}).addTo(map);
*/

// every time the marker is dragged, update the coordinates container
//marker.on('dragend', ondragend);

// Set the initial marker coordinate on load.
//ondragend();

/*
function ondragend() {
   var m = marker.getLatLng();
   coordinates.innerHTML = 'Latitude: ' + m.lat + '<br />Longitude: ' + m.lng;
}
*/
var Layers = [
omnivore.gpx('gpx/20140505.gpx'),
omnivore.gpx('gpx/20140506.gpx'),
omnivore.gpx('gpx/20140507.gpx'),
omnivore.gpx('gpx/20140508.gpx'),
omnivore.gpx('gpx/20140509.gpx'),
omnivore.gpx('gpx/20140510.gpx'),
omnivore.gpx('gpx/20140511.gpx'),
omnivore.gpx('gpx/20140512.gpx'),
omnivore.gpx('gpx/20140513.gpx'),
omnivore.gpx('gpx/20140514.gpx'),
omnivore.gpx('gpx/20140515.gpx'),
omnivore.gpx('gpx/20140516.gpx'),
omnivore.gpx('gpx/20140517.gpx'),
omnivore.gpx('gpx/20140518.gpx'),
omnivore.gpx('gpx/20140519.gpx'),
omnivore.gpx('gpx/20140520.gpx'),
omnivore.gpx('gpx/20140521.gpx'),
omnivore.gpx('gpx/20140522.gpx'),
omnivore.gpx('gpx/20140523.gpx'),
omnivore.gpx('gpx/20140524.gpx'),
omnivore.gpx('gpx/20140525.gpx'),
omnivore.gpx('gpx/20140526.gpx'),
omnivore.gpx('gpx/20140527.gpx'),
omnivore.gpx('gpx/20140528.gpx'),
omnivore.gpx('gpx/20140529.gpx'),
omnivore.gpx('gpx/20140530.gpx'),
omnivore.gpx('gpx/20140531.gpx'),
omnivore.gpx('gpx/20140601.gpx'),
omnivore.gpx('gpx/20140602.gpx'),
omnivore.gpx('gpx/20140603.gpx'),
omnivore.gpx('gpx/20140604.gpx'),
omnivore.gpx('gpx/20140605.gpx'),
omnivore.gpx('gpx/20140606.gpx'),
omnivore.gpx('gpx/20140607.gpx'),
omnivore.gpx('gpx/20140608.gpx'),
omnivore.gpx('gpx/20140609.gpx'),
omnivore.gpx('gpx/20140610.gpx'),
omnivore.gpx('gpx/20140611.gpx'),
omnivore.gpx('gpx/20140612.gpx'),
omnivore.gpx('gpx/20140613.gpx'),
omnivore.gpx('gpx/20140614.gpx'),
omnivore.gpx('gpx/20140615.gpx'),
omnivore.gpx('gpx/20140616.gpx'),
omnivore.gpx('gpx/20140617.gpx'),
omnivore.gpx('gpx/20140618.gpx'),
omnivore.gpx('gpx/20140619.gpx'),
omnivore.gpx('gpx/20140620.gpx'),
omnivore.gpx('gpx/20140621.gpx'),
omnivore.gpx('gpx/20140622.gpx'),
omnivore.gpx('gpx/20140623.gpx'),
omnivore.gpx('gpx/20140624.gpx'),
omnivore.gpx('gpx/20140625.gpx'),
omnivore.gpx('gpx/20140626.gpx'),
omnivore.gpx('gpx/20140627.gpx'),
omnivore.gpx('gpx/20140628.gpx'),
omnivore.gpx('gpx/20140629.gpx'),
omnivore.gpx('gpx/20140630.gpx'),
omnivore.gpx('gpx/20140701.gpx'),
omnivore.gpx('gpx/20140702.gpx'),
omnivore.gpx('gpx/20140703.gpx'),
omnivore.gpx('gpx/20140704.gpx'),
omnivore.gpx('gpx/20140705.gpx'),
omnivore.gpx('gpx/20140706.gpx'),
omnivore.gpx('gpx/20140716.gpx'),
omnivore.gpx('gpx/20140717.gpx'),
omnivore.gpx('gpx/20140718.gpx')
];

</script>



<article id='narrative'>
 <div class='sections prose'>
   <section id='cover' class='cover active'>
<h2>cycloscope</h2>
<?php
 if (file_exists('geotagged/cover/it.txt')) {
  $sezione=file('geotagged/cover/it.txt');
  echo "<section id='cover'>";
  echo "<h3>$sezione[0]</h3>";
  unset($sezione[0]);
  echo "<p>";
  foreach ($sezione as &$value) {
    echo $value;
  }
  echo"</p>";
 }
?>
     <big class='scroll quiet'>Leggi la nostra storia qui sotto: &#x25BE;</big>
   </section>

<?php
for ($offset=0;$offset<=90;$offset++) { 
 $data=date ( "Ymd", 1399248000 + ($offset*86400 ));
 if (file_exists('geotagged/' . $data . '/it.txt')) {
  $sezione=file('geotagged/' . $data . '/it.txt');
  echo "<section id='" .$data . "'>";
  echo "<h3>$sezione[0]</h3>";
  unset($sezione[0]);
  echo "<p>";
  foreach ($sezione as &$value) {
    echo $value;
  }
  echo "<br>&nbsp;<br><a href=\"gallery/index.php?dd=" . $data .  "&page=1\" target=_new>Foto Gallery della giornata</a>";
  echo"</p>";
  echo "</section>";
 }
}
?>

   <section id='cover' class='cover active' style=" background:#FFD018; color:#404040;">
<?php
 if (file_exists('geotagged/cover/it.txt')) {
  $sezione=file('geotagged/cover/it.txt');
  echo "<section id='cover'>";
  echo "<h3>$sezione[0]</h3>";
  unset($sezione[0]);
  echo "<p>";
  foreach ($sezione as &$value) {
    echo $value;
  }
  echo"</p>";
 }
?>
<center><img src=photo/Cycloscope.png></center>
     <big class='scroll quiet'>Continua a seguirci!<br>
Il nostro racconto preseguirà anche nei prossimi mesi.</big>
   </section>

 </div>
</article>

<gallery>
<img src=geotagged/cover/filmstrip.jpg id=filmstrip height=100%>
</gallery>

<script>
// In this case, we just hardcode data into the file. This could be dynamic.
// The important part about this data is that the 'id' property matches
// the HTML above - that's how we figure out how to link up the
// map and the data.
var places = { type: 'FeatureCollection', features: [
{ geometry: { type: "Point", coordinates: [15.5860,44.8900] },  properties: { id:    "cover", zoom: 4  }, type: 'Feature'},
{ geometry: { type: "Point", coordinates: [11.5672,44.6112] },  properties: { id: "20140505", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [12.0005,44.7826] },  properties: { id: "20140506", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [12.2702,45.1075] },  properties: { id: "20140507", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [12.5587,45.4487] },  properties: { id: "20140508", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [12.8037,45.5732] },  properties: { id: "20140509", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [12.9817,45.7076] },  properties: { id: "20140510", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [13.5309,45.7379] },  properties: { id: "20140511", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [13.8806,45.6774] },  properties: { id: "20140512", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [14.2262,45.5117] },  properties: { id: "20140513", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [14.729,45.3699] },  properties: { id: "20140514", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [15.2674,45.4495] },  properties: { id: "20140515", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [15.9887,45.5308] },  properties: { id: "20140516", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [16.7371,45.4166] },  properties: { id: "20140517", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [17.4268,45.2385] },  properties: { id: "20140518", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [18.0622,45.1021] },  properties: { id: "20140519", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [18.5055,44.9134] },  properties: { id: "20140520", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [18.9687,44.7181] },  properties: { id: "20140521", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [19.4141,44.6568] },  properties: { id: "20140522", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [19.6746,44.7546] },  properties: { id: "20140523", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [20.1501,44.8242] },  properties: { id: "20140524", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [20.9543,44.8023] },  properties: { id: "20140525", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [21.4639,44.7585] },  properties: { id: "20140526", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [21.8881,44.563] },  properties: { id: "20140527", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [22.4317,44.5787] },  properties: { id: "20140528", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [22.9979,44.8774] },  properties: { id: "20140529", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [23.671,45.0854] },  properties: { id: "20140530", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [24.2218,45.1979] },  properties: { id: "20140531", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [24.3365,45.2959] },  properties: { id: "20140601", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [24.5798,45.1942] },  properties: { id: "20140602", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [24.8793,44.7947] },  properties: { id: "20140603", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [25.1725,44.2361] },  properties: { id: "20140604", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [25.5374,44.0547] },  properties: { id: "20140605", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [26.0713,43.8467] },  properties: { id: "20140606", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [26.6766,43.4382] },  properties: { id: "20140607", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [27.4954,43.269] },  properties: { id: "20140608", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [27.9835,43.263] },  properties: { id: "20140609", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [28.005,43.3159] },  properties: { id: "20140610", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [28.0052,43.3159] },  properties: { id: "20140611", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [27.8444,43.246] },  properties: { id: "20140612", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [27.6784,43.1858] },  properties: { id: "20140613", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [27.8234,43.1924] },  properties: { id: "20140614", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [32.2216,42.8818] },  properties: { id: "20140615", zoom: 6 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [39.0056,42.3835] },  properties: { id: "20140616", zoom: 8 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [41.6654,41.8991] },  properties: { id: "20140617", zoom: 8 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [41.7521,41.8695] },  properties: { id: "20140619", zoom: 9 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [41.9545,42.6204] },  properties: { id: "20140621", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [42.0447,42.8209] },  properties: { id: "20140622", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [42.1308,42.9294] },  properties: { id: "20140623", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [42.1872,42.9449] },  properties: { id: "20140624", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [42.1309,42.9294] },  properties: { id: "20140628", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [42.066,42.6974] },  properties: { id: "20140629", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [43.406,42.1178] },  properties: { id: "20140630", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [44.7944,41.7219] },  properties: { id: "20140701", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [45.1175,41.7114] },  properties: { id: "20140705", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [45.6444,41.6753] },  properties: { id: "20140706", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [44.7096,41.7767] },  properties: { id: "20140716", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [44.5431,41.869] },  properties: { id: "20140717", zoom: 10 }, type: 'Feature' },
{ geometry: { type: "Point", coordinates: [44.3315,41.9319] },  properties: { id: "20140718", zoom: 10 }, type: 'Feature' }
]};


var placesLayer = L.mapbox.featureLayer(places)
   .addTo(map);

placesLayer.on('ready', function() {
    // featureLayer.getBounds() returns the corners of the furthest-out markers,
    // and map.fitBounds() makes sure that the map contains these.
    map.fitBounds(featureLayer.getBounds());
window.alert("ready");
});

// Ahead of time, select the elements we'll need -
// the narrative container and the individual sections
var narrative = document.getElementById('narrative'),
   sections = narrative.getElementsByTagName('section'),
   currentId = '';

setId('cover');

function setId(newId) {
   // If the ID hasn't actually changed, don't do anything
   if (newId === currentId) return;
   // Otherwise, iterate through layers, setting the current
   // marker to a different color and zooming to it.
   placesLayer.eachLayer(function(layer) {
       if (layer.feature.properties.id === newId) {
           map.setView(layer.getLatLng(), layer.feature.properties.zoom || 8);
/*
           layer.setIcon(L.mapbox.marker.icon({
               'marker-color': '#a8f'
           }));
*/
           layer.setIcon(L.mapbox.marker.icon({
            'marker-color': '#ffee00',
            'marker-symbol': 'star',
           }));
           layer.setOpacity(0);

       } else {
           layer.setIcon(L.mapbox.marker.icon({
               'marker-color': '#404040'
           }));
           layer.setOpacity(0);
       }

   });
   // highlight the current section
   for (var i = 0; i < sections.length; i++) {
       sections[i].className = sections[i].id === newId ? 'active' : '';
   }
   // And then set the new id as the current one,
   // so that we know to do nothing at the beginning
   // of this function if it hasn't changed between calls
   currentId = newId;
   //Agiorna la barra in basse con le foto
   document.getElementById('filmstrip').src='geotagged/' + currentId + '/filmstrip.jpg';
}

// If you were to do this for real, you would want to use
// something like underscore's _.debounce function to prevent this
// call from firing constantly.
narrative.onscroll = function(e) {
   var narrativeHeight = narrative.offsetHeight;
   var newId = currentId;
   // Find the section that's currently scrolled-to.
   // We iterate backwards here so that we find the topmost one.
   for (var i = sections.length - 1; i >= 0; i--) {
       var rect = sections[i].getBoundingClientRect();
       if (rect.top >= 0 && rect.top <= narrativeHeight) {
           newId = sections[i].id;
       }
   };
   setId(newId);
};


</script>

</body>
</html>
