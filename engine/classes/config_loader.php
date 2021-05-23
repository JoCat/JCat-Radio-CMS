<?php

class ConfigLoader
{
    static public function load($filename)
    {
        return json_decode(file_get_contents(ENGINE_DIR . '/data/' . $filename . '.json'));
    }

    static public function save($filename, $data)
    {
        file_put_contents(ENGINE_DIR . '/data/' . $filename . '.json', json_encode($data));
    }
}
