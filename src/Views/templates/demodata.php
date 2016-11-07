<?php
$result = $data['demodata'];
$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <ul>";
foreach ($result as $value){
    $html .= "<li><pre>" . $value . "</pre></li>";
}
$html .= "</ul>
        </body>
        </html>";
echo $html;