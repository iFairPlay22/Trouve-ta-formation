<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Trouve ta formation</title>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
         integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
         crossorigin=""/>
      <link rel="stylesheet" href="style/style.css">
   </head>
   <body>
      <?php
         //+Intégration des liens cliqués
         require("php/import_data.php");
         require("php/functions.php");
      ?>

      <header>
         <h1 id="header-title">
            Trouver sa formation
         </h1>
      </header>
      <section>
         <article class="flex-article">
            <h2 id="section-article-title">
               Formulaire
            </h2>
            <p style="text-align: center; margin-bottom: 20px;">
               Accédez aux résultats en remplissant <br>
               les champs optionnels ci dessous.
            </p>
            <form id="section-article-form" method="POST">
               <input name="begin" value ="0" hidden>
               <input name="end" value ="<?php print($limit); ?>" hidden>
               <?php
                  foreach ($labels as $column => $label) {
                     printForm($contents, $default, $column, $label);
                  }
               ?>

               <article class="section-article-form-article">
                  <input type="submit" value="Rechercher" class="section-article-form-article-inputbutton"/>
               </article>
            </form>
         </article>
         <article id="article-map">
            <div id="article-leatlet"></div>
            <button id="location-button">
               Géolocaliser
            </button>
         </article>
         <?php
            $localisations = array();
            if (isset($_POST["begin"])) {
               if (isset($_POST["end"])) {
            
                  printHeader($labels);
            
                  $localisations = printResult($contents, $default, $labels, $limit);
               }
            }
            ?>
      </section>
      <footer></footer>
   <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
      integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
      crossorigin=""></script>
   <script>
      //Setting initial coordinates
      var mymap = L.map('article-leatlet').setView([48.856614, 2.3522219], 5);

      //Adding map layer
      L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
         attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
         maxZoom: 18,
         id: 'mapbox.streets',
         accessToken: 'pk.eyJ1IjoibWFpYTIzIiwiYSI6ImNrMzV2dWlneTBicDMzY3FqNDRhcnNwZWkifQ.ZeUBSa9YEXLxt0BVV7okeA'
         }).addTo(mymap);

      document.getElementById("location-button").addEventListener("click", function() {
         mymap.locate({setView: true, maxZoom: 13});
      });
      
      <?php
         foreach ($localisations as $localisation) {
            print('L.marker([' . $localisation["x"] . ', ' . $localisation["y"] . ']).addTo(mymap).bindPopup("'. $localisation["etablissement_lib"] .'").openPopup();');
         }
      ?>
   </script>
   </body>
</html>