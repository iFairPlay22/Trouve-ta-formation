<?php

    // Print form

    function printOptions($contents, $default, $item) {
        $array = array();
        foreach ($contents["records"] as $key => $value) {
           array_push($array, $value["fields"][$item]);
        }
        $array = array_unique($array);
        sort($array); 
        foreach ($array as $value) {
           print("<option value=\"" . $value ."\">" . $value ."</option>");
        }
        print("<option value=\"" . $default ."\">" . $default ."</option>");
     }

     function printPlaceholder($name, $defaultName) {
        if (isset($_POST["$name"])) {
           if ($_POST["$name"] !== "") {
              print($_POST["$name"]);
              return ;
           }
        }
        print($defaultName);
     }

     function printForm($contents, $default, $column, $label) {
        print('<article class="section-article-form-article"><input list="' . $column . '" name="' . $column . '" placeholder="');

        printPlaceholder($column, $label);
        
        print('"/><datalist id="' . $column . '">');

        printOptions($contents, $default, $column);

        print('</datalist></article>');
     }

     // Print result

     function match($line, $default) {
        foreach ($_POST as $key => $value) {
           if ($key == "end" || $key == "begin" || $value == "" || $value == $default)
              continue;
           if ($line[$key] != $value) {
              return false;
           }
        }
        return true;
     }

     function printLine($line, $header) {
        print("<tr>");

        foreach ($header as $key => $value) {
           print("<td>" . $line[$key] . "</td>");
        }

        print("</tr>");
     }

     function addCoordinates($localisations, $com_ins, $etablissement_lib) {
        foreach ($localisations as $value) {
            if ($value["etablissement_lib"] === $etablissement_lib) {
               return ;
            }
        }

        $geolocalisation = json_decode(file_get_contents("https://geo.api.gouv.fr/communes/". $com_ins ."?fields=centre&format=json&geometry=centre"));
        if (isset($geolocalisation->centre)) {
           $localisation = array(
              "x" => $geolocalisation->centre->coordinates[1],
              "y" => $geolocalisation->centre->coordinates[0],
              "etablissement_lib" => $etablissement_lib,
           );
           if ($localisation["x"] != null && $localisation["y"] != null) {
              return $localisation;
           }
        }
        return null;
     }

     function printHeader($labels) {
      print("<article><table><tr>");
        foreach ($labels as $column => $label) {
            print("<th>" . $label . "</th>");
        }
        print("</tr>");
     }

     function printResult($contents, $default, $labels, $limit) {
        $parameters = array(
            "nbResults" => 0,
            "hasBefore" => false,
            "hasAfter" => false
        );

        $localisations = array();

        foreach ($contents["records"] as $key => $value) {
           if (match($value["fields"], $default)) {
              if ($parameters["nbResults"] < $_POST["begin"]) {
                $parameters["hasBefore"] = true;
              }
              if ($_POST["begin"] <= $parameters["nbResults"] && $parameters["nbResults"] < $_POST["end"]) {
                printLine($value["fields"], $labels);
                $coords = addCoordinates($localisations, $value["fields"]["com_ins"], $value["fields"]["etablissement_lib"]);
               if ($coords != null) {
                  array_push($localisations, $coords);
               }
               }
              if ($_POST["end"] <= $parameters["nbResults"]) {
                $parameters["hasAfter"] = true;
                break;
              }
              $parameters["nbResults"]++;
           }                     
        }
        print("</table>");
            
        if ($parameters["nbResults"] == 0) {
            print("<p>Aucun résultat ne correspond à vos critères de tri.");
        }

        if ($parameters["hasBefore"] || $parameters["hasAfter"]) {
            print('<div style="display: flex; align-items: center; justify-content: center; margin-top: 15px;"><div style="display: flex; align-items: center; justify-content: space-around; width:30%;">');
            if ($parameters["hasBefore"])
                printBeforeButton($limit);
            if ($parameters["hasAfter"])
                printAfterButton($limit);
            print('</div></div>');
        }  
        print("</article>");

        return $localisations;
     }

     // Print buttons

     function printBeforeButton($limit) {
        print('<form method="POST">');
        foreach ($_POST as $key => $value) {
           if ($key === "begin" || $key === "end") {
              print('<input name="' . $key . '" value="' . ((integer) $value - $limit) . '" type="hidden"/>');
           } else {
              print('<input name="' . $key . '" value="' . $value . '" type="hidden"/>');
           }
        }
        print('<input type="submit" value="Précédant" class="section-article-form-article-inputbutton"/></form>');
     }

     function printAfterButton($limit) {
        print('<form method="POST">');
        foreach ($_POST as $key => $value) {
           if ($key === "begin" || $key === "end") {
              print('<input name="' . $key . '" value="' . ((integer) $value + $limit) . '" type="hidden"/>');
           } else {
              print('<input name="' . $key . '" value="' . $value . '" type="hidden"/>');
           }
        }
        print('<input type="submit" value="Suivant" class="section-article-form-article-inputbutton"/></form>');
     }
?>