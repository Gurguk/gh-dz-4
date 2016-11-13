<?php

$university = $data['university'];
$do = $data['do'];
$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <div><a href='index.php?controller=university&action=index'><button>Повернутись до списку</button></a></div>
        <div>";
switch ($do) {
    case 'show':
        $html .= '<p> Назва: '.$university->university_name.'</p>
                  <p> Місто: ' .$university->university_city.'</p>
                  <p> Сайт: ' .$university->university_site.'</p>';
        break;
    case 'edit':
        $html .= "<form action='index.php?controller=university&action=update' method='post'>
              <p> Назва:<br/> <textarea name='send[name]' rows='5' cols='50'>" .$university->university_name."</textarea></p>
              <p> Місто: <input type='text' name='send[city]' value='" .$university->university_city."'/></p>
              <p> Сайт: <input type='text' name='send[site]' value='" .$university->university_site."'/></p>
              <input type='hidden' name='send[id]' value='" .$university->id."' />
              <input type='submit' value='Обновити дані' />
              </form>";
        break;
    case 'create':
        $html .= "<form action='index.php?controller=university&action=add' method='post'>
              <p> Назва:<br/> <textarea name='send[name]' rows='5' cols='50'></textarea></p>
              <p> Місто: <input type='text' name='send[city]' value=''/></p>
              <p> Сайт: <input type='text' name='send[site]' value=''/></p>
              <input type='hidden' name='send[id]' value='' />
              <input type='submit' value='Створити' />
              </form>";
        break;
    default:
        break;
}

$html .= '</div>
          </body>
          </html>';
echo $html;
