<?php

    class Config{
        static function get($key = null){
            $file = __DIR__."/../../config.json";

            if(!file_exists($file)){
                return null;
            }

            $config = file_get_contents($file);

            $config = json_decode($config, 1);

            if($key == null){
                return $config;
            }

            if(!array_key_exists($key, $config)){
                return null;
            }

            return $config[$key]; 

        }
    }

?>