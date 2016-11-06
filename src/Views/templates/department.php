<?php
$department = $data['department'];

$do = $data['do'];
$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <div><a href='index.php?controller=department&action=index'><button>Повернутись до списку</button></a></div>
        <div>";
switch ($do){
    case 'show':
        $html .= "<p> Факультет: " . $department->name . "</p>
                  <p> Університет: <a href='index.php?controller=university&action=show&id=" . $department->university_id . "'>" . $department->university_name . "</a></p>";
        break;
    case 'edit':
        $html .= "<form action='index.php?controller=department&action=update' method='post'>
              <p> Назва:<br/> <textarea name='send[name]' rows='5' cols='50'>" . $department->name . "</textarea></p>
              <p> ID університету: <input type='text' name='send[university_id]' value='" . $department->university_id . "'/></p>
              <input type='hidden' name='send[id]' value='" . $department->id . "' />
              <input type='submit' value='Обновити дані' />
              </form>";
        break;
    case 'create':
        $html .= "<form action='index.php?controller=department&action=add' method='post'>
              <p> Назва:<br/> <textarea name='send[name]' rows='5' cols='50'></textarea></p>
              <p> ID університету: <input type='text' name='send[university_id]' value=''/></p>
              <input type='hidden' name='send[id]' value='' />
              <input type='submit' value='Створити' />
              </form>";
        break;
    default:
        break;
}

$html .= "</div>
          </body>
          </html>";
echo $html;
