<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Trouve ta formation</title>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
         integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
         crossorigin=""/>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      <?php
         require("import/import_data.php");

         function printOptions($contents, $item) {
            $array = array();
            foreach ($contents["records"] as $key => $value) {
               array_push($array, $value["fields"][$item]);
            }
            $array = array_unique($array);
            sort($array); 
            foreach ($array as $value) {
               print("<option value=\"" . $value ."\">" . $value ."</option>");
            }
         }

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
            <form id="section-article-form" action="pages/result.php" method="POST">
               <article class="section-article-form-article">
                  <label for="studyLevel">Niveau d'études</label>
                  <select name="studyLevel" id="studyLevel">
                     <?php
                        printOptions($contents, "niveau_lib");
                     ?>
                  </select>
               </article>
               <article class="section-article-form-article">
                  <label for="studyName">Nom de formation</label>
                  <select name="studyName" id="studyName">
                     <?php
                        printOptions($contents, "diplome_lib");
                     ?>
                  </select>
               </article>
               <article class="section-article-form-article">
                  <label for="studyDomain">Domaine d'études</label>
                  <select name="studyDomain" id="studyDomain">
                     <?php
                        printOptions($contents, "gd_disciscipline_lib");
                     ?>
                  </select>
               </article>
               <article class="section-article-form-article">
                  <label for="region">Région</label>
                  <select name="region" id="region">
                     <?php
                        printOptions($contents, "reg_etab_lib");
                     ?>
                  </select>
               </article>
               <article class="section-article-form-article">
                  <label for="city">Ville</label>
                  <select name="city" id="city">
                     <?php
                        printOptions($contents, "com_etab_lib");
                     ?>
                  </select>
               </article>
               <article class="section-article-form-article">
                  <button class="section-article-form-article-button blue">
                     Rechercher
                  </button>
               </article>
            </form>
         </article>
         <article id="article-map">
            <div id="article-leatlet"></div>
            <button id="location-button">
              Géolocaliser
            </button>
         </article>
      </section>
      <footer>
      </footer>
   </body>
   <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
      integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
      crossorigin=""></script>
   <script type="text/javascript" src="leatlet.js"></script>
</html>