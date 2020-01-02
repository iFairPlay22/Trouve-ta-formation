<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Trouve ta formation</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
        require("../import/import_data.php");
    ?>
  <header>
    <h1 id="header-title">
        Trouver sa formation
    </h1>
  </header>

  <section>

    <article>

        <table>
            
            <?php
                print("<tr>");
                $lines = count($contents["parameters"]["facet"]);
                $arrayLines = array();
                foreach ($contents["parameters"]["facet"] as $value) {
                    array_push($arrayLines, $value);
                    print("<th>" . $value . "</th>");
                }
                print("</tr>");

                foreach ($contents["records"] as $key => $value) {
                    print("<tr>");
                    for ($i=0; $i < $lines; $i++) { 
                        $res = $value["fields"][$arrayLines[$i]];
                        if (in_array($res, $_GET)) {
                            print("<td>" . res . "</td>");
                        }
                    }
                    print("</tr>");
                }
            ?>

        </table>

    </article>
    
  </section>

  <footer>
    
  </footer>
</body>
</html>