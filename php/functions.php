<?php

    function console_log($data) { $output = json_encode($data); echo "<script>console.log(" . $output . ");</script>"; }

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

     function printForm($contents, $default, $column, $label) {
        print('<article class="section-article-form-article"><input list="' . $column . '" name="' . $column . '" placeholder="' . $label. '"');

        if (isset($_POST["$column"])) {
           if ($_POST["$column"] !== "") {
              print(' value="' . $_POST["$column"] . '"');
           }
        }
        
        print('/><datalist id="' . $column . '">');

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
     
     function addCoordinates(&$localisations) {
        fetchUrl_2($contents_2, $localisations);

        $result = array();

        foreach ($contents_2["records"] as $localisation) {

          $res = array(
              "x" => $localisation["fields"]["coordonnees"][0],
              "y" => $localisation["fields"]["coordonnees"][1],
              "etablissement_lib" => $localisation["fields"]["uo_lib"],
              "url" => $localisation["fields"]["url"],
              "nbResults" => 1
            );
            
            array_push($result, $res);
        }

        return $result;

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
                array_push($localisations, array(
                  "etablissement_lib" => $value["fields"]["etablissement_lib"], 
                  "com_ins" => $value["fields"]["com_ins"]
                ));
                //url
              }
              if ($_POST["end"] <= $parameters["nbResults"] && !($parameters["hasAfter"])) {
                $parameters["hasAfter"] = true;
              }
              $parameters["nbResults"]++;
           }                     
        }
        print("</table>");

        if ($parameters["hasBefore"] || $parameters["hasAfter"]) {
            print('<div style="display: flex; align-items: center; justify-content: center; margin-top: 15px;"><div style="display: flex; align-items: center; justify-content: space-around; width:30%;">');
            if ($parameters["hasBefore"])
                printBeforeButton($limit);
            if ($parameters["hasAfter"])
                printAfterButton($limit);
            print('</div></div>');
        }  

        if ($parameters["nbResults"] <= 0) {
            print('<p style="text-align: center;">Aucun résultat ne correspond à vos critères de tri.</p>');
        } else {
            $printElements = ($parameters["nbResults"] < intval($_POST["end"])) ? $parameters["nbResults"] : (intval(intval($_POST["end"])) - (intval($_POST["begin"])));
            print('<p style="text-align: center;">'. $printElements . " / " . $parameters["nbResults"] . " résultats affichés </p>");

            $localisations = addCoordinates($localisations);
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
        print('<input type="submit" value="Précédent" class="section-article-form-article-inputbutton"/></form>');
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