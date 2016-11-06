<?php

$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <div><a href='index.php?controller=university&action=create'><button>Додати новий</button></a></div>
        <div><br />
            <form action='index.php?controller=university&action=index' method='post'>
                <input type='text' name='search' value='" . $_POST['search'] . "' />
                <input type='submit' value='Пошук' />
            </form>
        </div>";
$html .= "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Місто</th>
                    <th>Сайт</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>";
foreach ($data['universities'] as $value){
    $html .= "<tr>
                <td>" . $value->id . "</td>
                <td>" . $value->university_name . "</td>
                <td>" . $value->university_city . "</td>
                <td>" . $value->university_site . "</td>
                <td><a href='index.php?controller=university&action=show&id=" . $value->id . "'>Детальніше</a>
                    <a href='index.php?controller=university&action=edit&do=edit&id=" . $value->id . "'>Редагувати</a>
                    <a href='index.php?controller=university&action=delete&id=" . $value->id . "'>Видалити</a></td>
              </tr>";
}
$html .= "</tbody>
          </table>";
$html .= "</body>
          </html>";
echo $html;
