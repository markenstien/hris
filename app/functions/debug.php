<?php 

    function pre($data)
    {
        echo '<pre>';
            var_dump($data);
        echo '</pre>';
    }

    function dump($data)
    {
        echo '<pre>';
            var_dump($data);
        echo '</pre>';

        die();
    }

    function dd($data)
    {
        $data = json_encode($data);
        die($data);
    }