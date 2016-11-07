<?php
$student = $data['student'];

$do = $data['do'];
$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <div><a href='index.php?controller=student&action=index'><button>Повернутись до списку</button></a></div>
        <div>";
switch ($do){
    case 'show':
        $html .= "<p> Ім'я: " . $student->first_name . "</p>
                  <p> Прізвище: " . $student->last_name . "</p>
                  <p> E-mail: " . $student->email . "</p>
                  <p> Телефон: " . $student->phone . "</p>
                  <p> Кафедра: " . $student->department_id . "</p>
                  ";
        break;
    case 'edit':
        $html .= "<form action='index.php?controller=student&action=update' method='post'>
              <p> Ім'я: <input type='text' name='send[first_name]' value='" . $student->first_name . "'/></p>
              <p> Прізвище: <input type='text' name='send[last_name]' value='" . $student->last_name . "'/></p>
              <p> E-mail: <input type='text' name='send[email]' value='" . $student->email . "'/></p>
              <p> Телефон: <input type='text' name='send[phone]' value='" . $student->phone . "'/></p>
              <p> Кафедра: <input type='text' name='send[department_id]' value='" . $student->department_id . "'/></p>
              <input type='hidden' name='send[id]' value='" . $student->id . "' />
              <input type='submit' value='Обновити дані' />
              </form>";
        break;
    case 'create':
        $html .= "<form action='index.php?controller=student&action=add' method='post'>
              <p> Ім'я: <input type='text' name='send[first_name]' value=''/></p>
              <p> Прізвище: <input type='text' name='send[last_name]' value=''/></p>
              <p> E-mail: <input type='text' name='send[email]' value=''/></p>
              <p> Телефон: <input type='text' name='send[phone]' value=''/></p>
              <p> Кафедра: <input type='text' name='send[department_id]' value=''/></p>
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
