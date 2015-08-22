<?php
namespace Cygnite\Mvc\View;

use Cygnite\AssetManager\Asset;
use Cygnite\Common\UrlManager\Url;
use Cygnite\Reflection;

if (!defined('CF_SYSTEM')) {
    exit('External script access not allowed');
}
/**
 * Class Template
 * This file is used to Define all necessary configurations for twig template engine
 *
 * @package Cygnite\Mvc\View
 */
class Template
{
    public $methods;
    /**
     * @var view
     */
    private $view;
    // Set default functions to twig engine
    public $functions;

    private $validMethods = [
        'getAutoReload',
        'isDebugModeOn',
        'getTemplateExtension',
        'getLayout'
    ];

    public $twig;
    /**
     * @param            $view
     */
    public function configure($view)
    {
        \Twig_Autoloader::register();
        $this->view = $view;

        /*
         | We will get all the necessary user configuration set
         | in controller by the user and set into template method array.
         | based on user provided configuration we will set twig environment
         */
        foreach ($this->validMethods as $key => $method) {
            if (method_exists($this->view, $method)) {
                $this->setValue($method);
            }
        }
    }

    /**
     * @param $property
     */
    public function setValue($method)
    {
        $this->methods[$method] = $this->view->{$method}();
    }

    /**
     * @return \Twig_Environment
     */
    public function setEnvironment()
    {
        $this->methods['twigLoader'] = new \Twig_Loader_Filesystem($this->view->getTemplateLocation());
        $this->twig = new \Twig_Environment($this->methods['twigLoader'], array(
            'cache' => CYGNITE_BASE.DS. 'public'.DS.'storage' . DS . 'temp' . DS . 'twig' . DS . 'tmp' . DS . 'cache',
            'auto_reload' => $this->methods['getAutoReload'],
            'debug' => $this->methods['isDebugModeOn'],
        ));

        $this->setDefaultFunctions();

        return $this->twig;
    }

    public function setDefaultFunctions()
    {
        $this->setLink() //set link() function
             ->setTwigBaseUrl(); //set baseUrl() function

        foreach ($this->functions as $key => $func) {
            $this->twig->addFunction($func);
        }
    }

    private function setTwigBaseUrl()
    {
        // We will set baseUrl as default function to twig engine
        $this->functions[] = $this->getTwigSimpleFunctionInstance(
            'baseUrl',
            function () {
                return Url::getBase();
            }
        );

        return $this;
    }

    /**
     * @param $name
     * @param $callback
     * @return \Twig_SimpleFunction
     */
    public function getTwigSimpleFunctionInstance($name, $callback)
    {
        return new \Twig_SimpleFunction($name, $callback);
    }

    /**
     * @return $this
     */
    private function setLink()
    {
        // We will set default function to twig engine
        $this->functions[] = $this->getTwigSimpleFunctionInstance(
            'link',
            function ($link, $name = null, $attributes = []) {
                return Asset::anchor(str_replace('.', '/', $link), $name, $attributes);
            }
        );

        return $this;
    }

    /**
     * @param null $extension
     * @return void
     */
    public function addExtension($extension = null)
    {
        if ($extension == null) {
            $this->view->tpl->{__FUNCTION__}(new \Twig_Extension_Debug());
        } else {
            $this->view->tpl->{__FUNCTION__}($extension);
        }
    }

    /**
     * @param null     $funcName
     * @param callable $callback
     */
    public function addFunction($funcName = null, \Closure $callback = null)
    {
        if ($callback !== null && $callback instanceof \Closure) {
            $this->view->tpl->{__FUNCTION__}(new \Twig_SimpleFunction($funcName, $callback));
        } else {
            $this->view->tpl->{__FUNCTION__}($funcName, $callback);
        }
    }
}
