<?php

/* products\create.html.twig */
class __TwigTemplate_f75e3be2bfe72039e7ebb166c5c69af9676321955f2c35f5d92560e9f2c057d7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout/main/base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/main/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "    Cygnite framework - Simple Crud Operation
";
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "

    ";
        // line 11
        echo "
    <div style=\"float:right;margin-right:47px; margin-bottom: 10px;margin-top: 10px;\">
    ";
        // line 13
        echo call_user_func_array($this->env->getFunction('link')->getCallable(), array("products", "Back", $this->getAttribute((isset($context["buttonAttributes"]) ? $context["buttonAttributes"] : null), "primary")));
        echo "
    </div>

    <div style=\"color:#FF0000;\">
        ";
        // line 17
        echo (isset($context["validation_errors"]) ? $context["validation_errors"] : null);
        echo "
    </div>

    <div style=\"float:left;\">
        ";
        // line 21
        echo (isset($context["registration"]) ? $context["registration"] : null);
        echo "
    </div>


";
    }

    // line 27
    public function block_footer($context, array $blocks = array())
    {
        // line 28
        echo "
";
    }

    public function getTemplateName()
    {
        return "products\\create.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 28,  72 => 27,  63 => 21,  56 => 17,  49 => 13,  45 => 11,  41 => 8,  38 => 7,  33 => 4,  30 => 3,);
    }
}
