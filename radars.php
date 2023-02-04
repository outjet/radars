<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Webcam Images</title>
    <style>

        body{
           font-family: 'Open Sans', sans-serif;
           font-weight: 600;
        }

        /* CSS styles for the images grid */
         .radar-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: 1fr 1fr;
            grid-gap: 10px;
            max-height: 600px;
            overflow: hidden;
        }

        .radar-grid img {
            object-fit: cover;
            max-width: 460px; /* sets a maximum width of 360px */
            max-height: 460px; /* sets a maximum height of 360px */
            object-fit: contain; /* preserves the aspect ratio of the image */
        }
        .image-grid {
            display: flex;
            flex-wrap: wrap;
        }
        .image-grid img {
            max-width: 360px;
            max-height: 360px;
            object-fit: cover;
            margin-right: 10px;
            flex-basis: calc(33.33% - 20px);
        }
        /* CSS for the loading message */
        .loading {
            text-align: center;
            font-size: 24px;
            margin-top: 50px;
        }
        
          .sensor-container {
            display: flex; /* use flexbox layout */
            justify-content: space-between; /* evenly space the elements horizontally */
        }
        
        .sensor-box {
            width: 17%;
            margin-right: 2%;
            padding: 10px;
            box-sizing: border-box;
            background-color: green;
            color: white;
            font-size: 0.8em;
        }

        
        .sensor-box.IceWatch {
            background-color: red;
            color: white;
        }
                
        img.radars {
            max-width: 360px; /* sets a maximum width of 360px */
            max-height: 360px; /* sets a maximum height of 360px */
            object-fit: contain; /* preserves the aspect ratio of the image */
        }

        .image-grid div {
            width: 300px;
            height: 200px;
            overflow: hidden;
            margin: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 3px #ccc;
            }

.image-grid img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.image-grid .caption {
  padding: 0;
  margin: 0;
  font-size: 12px;
  font-style: italic;
  text-shadow: 1px 1px #ccc;
  background-color: rgba(222, 222, 222, 0.8);
  width: 100%;
}



            .refresh-button {
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 10px;
            }

    </style>
    
    
<script>
  var loading = document.querySelector('.loading');
  var imageGrid = document.querySelector('.image-grid');
  if (imageGrid.children.length > 0) {
    loading.style.display = 'none';
    imageGrid.style.display = 'flex';
  }
</script>
        <script>
                function updateTime() {
                    var localTime = new Date().toLocaleString("en-US", {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                    var UTCtime = new Date(Date.now()).toLocaleString("en-US", {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true,
                        timeZone: 'UTC'
                    });
                    document.getElementById("local-time").innerHTML = localTime;
                    document.getElementById("utc-time").innerHTML = UTCtime;
                }
                setInterval(updateTime, 1000);
            </script>
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
        echo $sensor->name . "<br>";
        echo "Status: " . $sensor->status . "<br>";
        echo "</div>";
        $counter++;
    }
}


?>
    <div class='sensor-box' style='background-color:#DDD'>    
<a href="https://marine.weather.gov/MapClick.php?x=175&amp;y=108&amp;site=cle&amp;zmx=&amp;zmy=&amp;map_x=174&amp;map_y=108#.YMdzQJNKiHE" target="_blank">Marine forecast</a>
<BR>
<a href="https://forecast.weather.gov/product.php?site=CLE&amp;issuedby=CLE&amp;product=AFD&amp;format=CI&amp;version=1&amp;glossary=1&amp;highlight=off" target="_blank">Forecast discussion</a> 
<BR>
<a href="https://icyroadsafety.com/lcr/" target="_blank">Icy Road Forecast</a>
    </div>
    <div class='sensor-box' style='background-color:#DDD;color:#333;'>    
        <div>Local Time: <span id="local-time"></span></div>
        <div>UTC Time: <span id="utc-time"></span></div>
    </div>
</div>


<div style="clear: both;"></div> <BR>
    
<div class="image-grid">
    <?php
        $api_url = "https://publicapi.ohgo.com/api/v1/cameras?map-bounds-sw=41.46,-81.83&map-bounds-ne=41.49,-81.75";
        $headers = array(
            "Authorization: APIKEY 756bfc1c-746a-4a04-bc43-6c05521180e8",
            "Cache-Control: public, max-age=60",
            "Expires: " . gmdate("D, d M Y H:i:s", time() + 60) . " GMT"
        );
        $cache_file = 'camera-data.json';
        $cache_time = 60; // cache time in seconds
        $use_cache = false;

        if (isset($_GET['refresh'])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            curl_close($ch);
            file_put_contents($cache_file, $output);
        } else if (file_exists($cache_file) && (time() - $cache_time < filemtime($cache_file))) {
            $use_cache = true;
            $output = file_get_contents($cache_file);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            curl_close($ch);
            file_put_contents($cache_file, $output);
        }

        $output_array = json_decode($output, true);
        // Show loading message for 1 second before displaying images
        echo "<script>setTimeout(function(){document.querySelector('.loading').style.display = 'none'}, 1000);</script>";
        foreach ($output_array['results'] as $camera) {
            echo "<div>";
            echo "<img src='" . $camera['cameraViews'][0]['smallUrl'] . "' alt='" . $camera['description'] . "'>";
            echo "<div class='caption'>" . $camera['cameraViews'][0]['mainRoute'] . "</div>";
            echo "</div>";
          }          
    ?>
</div>
<button class="refresh-button" onclick="location.href = '<?php echo basename($_SERVER['PHP_SELF']) . "?refresh=true"; ?>'">Refresh Cameras</button>


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

<div style="clear: both;"></div> <BR>

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
