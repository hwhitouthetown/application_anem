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
        $__internal_d4361107053bede26c2d063b751e638bf4b323509e98bcd6db6683020fe15034 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d4361107053bede26c2d063b751e638bf4b323509e98bcd6db6683020fe15034->enter($__internal_d4361107053bede26c2d063b751e638bf4b323509e98bcd6db6683020fe15034_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_d4361107053bede26c2d063b751e638bf4b323509e98bcd6db6683020fe15034->leave($__internal_d4361107053bede26c2d063b751e638bf4b323509e98bcd6db6683020fe15034_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_db5714fd02a765104204235d742be2424446664a2b80f4e27e6e43bfc891b8dc = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_db5714fd02a765104204235d742be2424446664a2b80f4e27e6e43bfc891b8dc->enter($__internal_db5714fd02a765104204235d742be2424446664a2b80f4e27e6e43bfc891b8dc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_db5714fd02a765104204235d742be2424446664a2b80f4e27e6e43bfc891b8dc->leave($__internal_db5714fd02a765104204235d742be2424446664a2b80f4e27e6e43bfc891b8dc_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_3e0b418b8bcb5ebd08827df99d578a2946200576ca8d93e7ef8f0e95ff22b813 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3e0b418b8bcb5ebd08827df99d578a2946200576ca8d93e7ef8f0e95ff22b813->enter($__internal_3e0b418b8bcb5ebd08827df99d578a2946200576ca8d93e7ef8f0e95ff22b813_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_3e0b418b8bcb5ebd08827df99d578a2946200576ca8d93e7ef8f0e95ff22b813->leave($__internal_3e0b418b8bcb5ebd08827df99d578a2946200576ca8d93e7ef8f0e95ff22b813_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_cc4303354181a99f53a21675425027d45f3d6af0f2687acd9c3879b26a051b4a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_cc4303354181a99f53a21675425027d45f3d6af0f2687acd9c3879b26a051b4a->enter($__internal_cc4303354181a99f53a21675425027d45f3d6af0f2687acd9c3879b26a051b4a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_cc4303354181a99f53a21675425027d45f3d6af0f2687acd9c3879b26a051b4a->leave($__internal_cc4303354181a99f53a21675425027d45f3d6af0f2687acd9c3879b26a051b4a_prof);

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
