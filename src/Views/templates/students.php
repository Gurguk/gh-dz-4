<?php

$html = "<!doctype html>
        <html>
        <body>
        <div><a href='index.php'><< Головна</a></div><br/>
        <div><a href='index.php?controller=student&action=create'><button>Додати нового</button></a></div>
        <div><br />
            <form action='index.php?controller=student&action=index' method='post'>
                <input type='text' name='search' value='" .$_POST['search']."' />
                <input type='submit' value='Пошук' />
            </form>
        </div>";
$html .= "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Факультет</th>
                    <th>Ім'я</th>
                    <th>E-mail</th>
                    <th>Телефон</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>";
foreach ($data['student'] as $value) {
    $html .= '<tr>
                <td>' .$value->id.'</td>
                <td>' .$value->department_id.'</td>
                <td>' .$value->first_name.' '.$value->last_name.'</td>
                <td>' .$value->email.'</td>
                <td>' .$value->phone."</td>
                <td><a href='index.php?controller=student&action=show&id=" .$value->id."'>Детальніше</a>
                    <a href='index.php?controller=student&action=edit&do=edit&id=" .$value->id."'>Редагувати</a>
                    <a href='index.php?controller=student&action=delete&id=" .$value->id."'>Видалити</a></td>
              </tr>";
}
$html .= '</tbody>
          </table>';
$html .= '</body>
          </html>';
echo $html;
