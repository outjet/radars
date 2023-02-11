<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Radars</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <script src="scripts/updateTime.js"></script>
    <script src="scripts/refreshCams.js"></script>

</head>
<body onload="updateTime()">
<div class='sensor-container'>
<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://publicapi.ohgo.com/api/v1/weather-sensor-sites?map-bounds-sw=41.213,-81.9&map-bounds-ne=41.506,-81.69",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: APIKEY 756bfc1c-746a-4a04-bc43-6c05521180e8"
  ),
));

$response = curl_exec($curl);
$data = json_decode($response);

curl_close($curl);

$counter = 0;
foreach($data->results as $result) {
    foreach($result->surfaceSensors as $sensor) {
      if ($counter >= 3) break;
            echo "<div class='sensor-box";
        if($sensor->status == 'Ice Watch') {
            echo " IceWatch";
        }
        echo "'>";
        echo substr($sensor->name, 0, -4) . "<br>";
        echo "Status: " . $sensor->status . "<br>";
        echo "</div>";
        $counter++;
    }
}


?>
    <div class='sensor-box' style='background-color:#DDD'>    
<!--<a href="https://marine.weather.gov/MapClick.php?x=175&amp;y=108&amp;site=cle&amp;zmx=&amp;zmy=&amp;map_x=174&amp;map_y=108#.YMdzQJNKiHE" target="_blank">Marine forecast</a>-->
<a href="https://forecast.weather.gov/product.php?site=CLE&amp;issuedby=CLE&amp;product=AFD&amp;format=CI&amp;version=1&amp;glossary=1&amp;highlight=off" target="_blank">Forecast discussion</a>
<BR>
<a href="https://icyroadsafety.com/lcr/" target="_blank">Icy Road Forecast</a>
    </div>
    <div class='sensor-box' id='clocks' style='background-color:#DDD;color:#333;'>    
        <div><span id="local-time"></span> ET</div>
        <div><span id="utc-time"></span> UTC</div>
        <DIV><span id="refresh-paused" style="display:none;">REFRESH PAUSED</span></DIV>
    </div>
</div>




<div class="image-grid">

   <?php
        $api_url = "https://publicapi.ohgo.com/api/v1/cameras?map-bounds-sw=41.46,-81.83&map-bounds-ne=41.49,-81.75";
        $headers = array(
            "Authorization: APIKEY 756bfc1c-746a-4a04-bc43-6c05521180e8",
        );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            curl_close($ch);

        $output_array = json_decode($output, true);
        foreach ($output_array['results'] as $camera) {
            echo "<div>";
            echo "<img src='" . $camera['cameraViews'][0]['smallUrl'] . "' alt='" . $camera['description'] . "'>";
            echo "<div class='caption'>" . $camera['cameraViews'][0]['mainRoute'] . "</div>";
            echo "</div>";
          }          
    ?>
</div>

<div class="radar-grid">
    <div>
        <img src="https://cdn.tegna-media.com/wkyc/weather/myownradar/comp/880x495/cleveland15.gif" alt="Image 1">
    </div>
    <div>
        <img src="https://media.psg.nexstardigital.net/WJW/weather/west.jpg" alt="Image 2">
    </div>
    <div>
        <img src="https://sirocco.accuweather.com/nx_mosaic_640x480_public/sir/inmsiroh_.gif" alt="Image 3">
    </div>
    <div>
    <a href="https://www.star.nesdis.noaa.gov/GOES/conus_band.php?sat=G16&amp;band=GEOCOLOR&amp;length=24" target="new"><img src="https://cdn.star.nesdis.noaa.gov/GOES16/ABI/SECTOR/cgl/GEOCOLOR/GOES16-CGL-GEOCOLOR-600x600.gif" alt="Image 4"></a>
   </div>
</div>

<div style="clear: both;"></div> 

<br />
<img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.479&amp;lon=-81.8124&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=0&amp;pcmd=10111110111110000000000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /> <img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.479&amp;lon=-81.8124&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=48&amp;pcmd=10111110111110000000000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /> <img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.479&amp;lon=-81.8124&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=96&amp;pcmd=10111110111110000000000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /><br />
<img src="http://wxmaps.org/pix/clegfs.png" /><img src="http://wxmaps.org/pix/clegfsb.png" /><br />
<img src="https://www.glerl.noaa.gov//res/glcfs/ncast/eswt-00.gif" /><br />
<img src="https://www.glerl.noaa.gov//res/glcfs/ncast/ewv-00.gif" /><br />
&nbsp;</p>

<p><iframe height="4700px" src="meteos.html" width="1400px"></iframe></p>

<p><a href="https://www.glerl.noaa.gov/res/glcfs/ice.php?lake=eri" target="_blank"><img alt="" src="https://www.glerl.noaa.gov/data/ice/spaghetti/eri_ice_compare.png" style="width: 1500px; height: 850px;" /></a></p>

<p><a href="https://www.nhc.noaa.gov/"><img src="https://www.nhc.noaa.gov/xgtwo/two_atl_0d0.png?061759" /></a></p>

<p><br />
<strong>Dusk Progression</strong><br />
6:00 January 22<br />
6:15 February 3<br />
6:30 February 16<br />
6:45 March 1<br />
6:57 March 11<br />
7:58 March 12<br />
&nbsp;</p>
<!--
<p>Waves<br />
<img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.513&amp;lon=-81.8124&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=0&amp;pcmd=00000000000000000101000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /> <img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.513&amp;lon=-81.8124&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=48&amp;pcmd=00000000000000000101000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /> <img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.513&amp;lon=-81.8124&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=96&amp;pcmd=00000000000000000101000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /><br />
Airport<br />
<img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.410&amp;lon=-81.8545&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=0&amp;pcmd=00001000000000011000000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /> <img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.410&amp;lon=-81.8545&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=48&amp;pcmd=00001000000000011000000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /> <img src="https://marine.weather.gov/meteograms/Plotter.php?lat=41.410&amp;lon=-81.8545&amp;wfo=CLE&amp;zcode=LEZ146&amp;gset=20&amp;gdiff=6&amp;unit=0&amp;tinfo=EY5&amp;ahour=96&amp;pcmd=00001000000000011000000000000000000000000000000000000000000&amp;lg=en&amp;indu=0!1!1!&amp;dd=&amp;bw=&amp;hrspan=48&amp;pqpfhr=6&amp;psnwhr=6" /></p>
-->

<!--
<p><iframe height="480" src="http://radblast.wunderground.com/cgi-bin/radar/WUNIDS_map?station=CLE&amp;brand=wui&amp;num=20&amp;delay=11&amp;type=NCR&amp;frame=0&amp;scale=0.560&amp;noclutter=0&amp;lat=41.30609894&amp;lon=-81.85630035&amp;label=Strongsville%2C+OH&amp;showstorms=0&amp;map.x=800&amp;map.y=640&amp;centerx=422&amp;centery=180&amp;transx=22&amp;transy=-60&amp;showlabels=1&amp;severe=0&amp;rainsnow=0&amp;lightning=0&amp;smooth=0" style=";margin:0px;z-index:1;&quot;" width="640"></iframe><br />
<iframe height="480" src="http://radblast.wunderground.com/cgi-bin/radar/WUNIDS_map?station=CLE&amp;brand=wui&amp;num=20&amp;delay=11&amp;type=NCR&amp;frame=0&amp;scale=0.160&amp;noclutter=0&amp;lat=41.30609894&amp;lon=-81.85630035&amp;label=Strongsville%2C+OH&amp;showstorms=0&amp;map.x=800&amp;map.y=640&amp;centerx=422&amp;centery=180&amp;transx=22&amp;transy=-60&amp;showlabels=1&amp;severe=0&amp;rainsnow=0&amp;lightning=0&amp;smooth=0" style=";margin:0px;z-index:3;&quot;" width="640"></iframe>--->


</body>
</html>
