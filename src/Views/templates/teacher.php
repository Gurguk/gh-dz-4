<?php

$student = $data['teacher'];

$do = $data['do'];
$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <div><a href='index.php?controller=teacher&action=index'><button>Повернутись до списку</button></a></div>
        <div>";
switch ($do) {
    case 'show':
        $html .= "<p> Ім'я: ".$teacher->first_name.'</p>
                  <p> Прізвище: ' .$teacher->last_name.'</p>
                  <p> Кафедра: ' .$teacher->department_id.'</p>
                  ';
        break;
    case 'edit':
        $html .= "<form action='index.php?controller=teacher&action=update' method='post'>
              <p> Ім'я: <input type='text' name='send[first_name]' value='" .$teacher->first_name."'/></p>
              <p> Прізвище: <input type='text' name='send[last_name]' value='" .$teacher->last_name."'/></p>
              <p> Кафедра: <input type='text' name='send[department_id]' value='" .$teacher->department_id."'/></p>
              <input type='hidden' name='send[id]' value='" .$teacher->id."' />
              <input type='submit' value='Обновити дані' />
              </form>";
        break;
    case 'create':
        $html .= "<form action='index.php?controller=teacher&action=add' method='post'>
              <p> Ім'я: <input type='text' name='send[first_name]' value=''/></p>
              <p> Прізвище: <input type='text' name='send[last_name]' value=''/></p>
              <p> Кафедра: <input type='text' name='send[department_id]' value=''/></p>
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
