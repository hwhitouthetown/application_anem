<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_624c28e074aaee47a49e86db231e82468176a92fdc849bf01f42a7a975cb0969 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_45f07031a4a5d1f27601f3b349ecbb34c9d832970651a6506feee19c77835b35 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_45f07031a4a5d1f27601f3b349ecbb34c9d832970651a6506feee19c77835b35->enter($__internal_45f07031a4a5d1f27601f3b349ecbb34c9d832970651a6506feee19c77835b35_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_45f07031a4a5d1f27601f3b349ecbb34c9d832970651a6506feee19c77835b35->leave($__internal_45f07031a4a5d1f27601f3b349ecbb34c9d832970651a6506feee19c77835b35_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_0fcb095aa90a55eba5c9c5d93371b04382ce70246c1fce961b843dcbb72639b9 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0fcb095aa90a55eba5c9c5d93371b04382ce70246c1fce961b843dcbb72639b9->enter($__internal_0fcb095aa90a55eba5c9c5d93371b04382ce70246c1fce961b843dcbb72639b9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_0fcb095aa90a55eba5c9c5d93371b04382ce70246c1fce961b843dcbb72639b9->leave($__internal_0fcb095aa90a55eba5c9c5d93371b04382ce70246c1fce961b843dcbb72639b9_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_dd8d7c77c783a4db5070355b62d55982e6fc4f616dda38790adcf276a1c0a9e1 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_dd8d7c77c783a4db5070355b62d55982e6fc4f616dda38790adcf276a1c0a9e1->enter($__internal_dd8d7c77c783a4db5070355b62d55982e6fc4f616dda38790adcf276a1c0a9e1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_dd8d7c77c783a4db5070355b62d55982e6fc4f616dda38790adcf276a1c0a9e1->leave($__internal_dd8d7c77c783a4db5070355b62d55982e6fc4f616dda38790adcf276a1c0a9e1_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_e1542a57d3864e566a1fc4330c8a29ee527e72eb506b284f3e67d1f57fe1a370 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_e1542a57d3864e566a1fc4330c8a29ee527e72eb506b284f3e67d1f57fe1a370->enter($__internal_e1542a57d3864e566a1fc4330c8a29ee527e72eb506b284f3e67d1f57fe1a370_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_e1542a57d3864e566a1fc4330c8a29ee527e72eb506b284f3e67d1f57fe1a370->leave($__internal_e1542a57d3864e566a1fc4330c8a29ee527e72eb506b284f3e67d1f57fe1a370_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Twig/layout.html.twig' %}

{% block head %}
    <link href=\"{{ absolute_url(asset('bundles/framework/css/exception.css')) }}\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
{% endblock %}

{% block title %}
    {{ exception.message }} ({{ status_code }} {{ status_text }})
{% endblock %}

{% block body %}
    {% include '@Twig/Exception/exception.html.twig' %}
{% endblock %}
", "@Twig/Exception/exception_full.html.twig", "/var/www/html/application_anem/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views/Exception/exception_full.html.twig");
    }
}
