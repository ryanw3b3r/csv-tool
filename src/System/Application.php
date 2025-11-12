<?php

namespace CsvTool\System;

class Application
{
    protected Router $router;

    public function start()
    {
        define('ROOT_DIR', realpath(dirname(__FILE__) .'/../../'));
        define('VIEW_DIR', ROOT_DIR .'/views');
        define('CONFIG_DIR', ROOT_DIR .'/config');

        $this->router = new Router();
        
        return $this->router->process();
    }
}
