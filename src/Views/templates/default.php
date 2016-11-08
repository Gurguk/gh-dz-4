<?php

$html = '<!doctype html>
        <html>
        <body>
        <ul>
        <li><a href="index.php?controller=demodata&action=index">Створити структуру БД</li>
        <li><a href="index.php?controller=demodata&action=demo">Додати демо-дані</li>
        <li><a href="index.php?controller=university&action=index">Університети</li>
        <li><a href="index.php?controller=department&action=index">Кафедри</li>
        <li><a href="index.php?controller=student&action=index">Студенти</li>
        <li><a href="index.php?controller=teacher&action=index">Викладачі</li>
        </ul>
        </body>
        </html>';
echo $html;
