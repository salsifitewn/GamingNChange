<?php

namespace App;

class Router
{

    private $viewPath;

    private $router;

    public function __construct(string $view_Path)
    {
        $this->viewPath = $view_Path;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null)
    {
        $this->router->map('GET|POST', $url, $view, $name);
        //$this->router->map('POST', $url, $view, $name);

        //return $this;
    }

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }
    public function run()
    {
        $match = $this->router->match();
        $view = $match['target'] ;
        if(is_null($view)){
         $view="pageError";
        }
        $router=$this;  
        ob_start();
        require $this->viewPath . '/' . $view . '.php';
        $pageContent = ob_get_clean();
        require $this->viewPath . '/elements/layout.php';
    }
}
