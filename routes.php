<?php

    Router::config([
        new Route('', function(){
            require __DIR__.'/response/home.php';
        }),
    ]);

?>