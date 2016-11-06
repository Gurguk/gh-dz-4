<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06.11.16
 * Time: 17:37
 */

namespace Views;


class Render
{
    public function __construct()
    {

    }

    public function display($template, $data)
    {

        if (is_array($data) && !empty($data)) {
            extract($data);
        }
        ob_start();
        include  __DIR__.'/templates/' . $template . '.php';

        return ob_get_clean();
    }
}