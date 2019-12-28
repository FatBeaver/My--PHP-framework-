<?php

namespace epframe\libs;

class Cache
{
    public function __construct()
    {

    }

    public function set($key, $data, $seconds = 3600)
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content)))
        {
            return true;
        }
        return false;
    }

    public function get($key)
    {   
        $pathToFile = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($pathToFile)) {
            $content = unserialize(file_get_contents($pathToFile));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($pathToFile);
        }
        return false;
    }

    public function delete($key)
    {
        $pathToFile = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($pathToFile)) {
            unlink($pathToFile);
        }
    }
}