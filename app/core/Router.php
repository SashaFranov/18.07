<?php

namespace app\core;
use Couchbase\DropUserOptions;

class Router
{
    protected $params = [];

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        if (!empty($url)) {
            if(strpos($url, '?') !== false) {
                $link = explode('?',$url);
                if (!empty($link[0])) {
                    $url = $link[0];
                }
            }
            $params = explode('/', $url);
            if (!empty($params[0]) && !empty($params[1])) {
                $this->params = [
                    'controller' => $params[0],
                    'action' => $params[1]
                ];
            } else {
                return false;
            }
        } else {
            $params = require 'app/config/params.php';
            $this->params=[
                'controller' => $params['defaultController'],
                'action' => $params['defaultAction']
            ];
        }
        return true;
    }

    public function run()
    {
        if ($this->match()) {
            $path_controller = 'app\\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path_controller)) {
                $action = 'action' . ucfirst($this->params['action']);
                if (method_exists($path_controller, $action)) {
                    $controller = new $path_controller($this->params);
                    $behaviors = $controller->behaviors();
                    if ($this->checkBehaviors($behaviors)) {
                        $controller->$action();
                    }
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
private function checkBehaviors($behaviros)
{
    if(empty($behaviros['access']['rules'])){
        return true;
    }
    foreach ($behaviros['access']['rules'] as $rule){
        if (in_array($this->params['action'], $rule)){
            if (in_array(UserOperations::getRoleuser(), $rule['roles'])){
                return true;
            } else{
                if (isset($rule['matchCallback'])){
                    call_user_func($rule['matchCallback']);
                } else{
                    View::errorCode(403);
                }
                return false;
            }
        }
    }
    return true;
}
}

