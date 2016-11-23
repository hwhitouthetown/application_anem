<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_64cadfde72f9846021d7f68c0cf9306d52832775e73fbcb23b70571cb05bc67f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_ae81fecae81720d78c866fba1631002a6d4dd9b2e3b2e170c2c4f454ab33a94d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ae81fecae81720d78c866fba1631002a6d4dd9b2e3b2e170c2c4f454ab33a94d->enter($__internal_ae81fecae81720d78c866fba1631002a6d4dd9b2e3b2e170c2c4f454ab33a94d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_ae81fecae81720d78c866fba1631002a6d4dd9b2e3b2e170c2c4f454ab33a94d->leave($__internal_ae81fecae81720d78c866fba1631002a6d4dd9b2e3b2e170c2c4f454ab33a94d_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_ff8d77fba3b6a5c7217d8eb5e698ba6a34dafe94d2385be4d68cc6b485489b36 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ff8d77fba3b6a5c7217d8eb5e698ba6a34dafe94d2385be4d68cc6b485489b36->enter($__internal_ff8d77fba3b6a5c7217d8eb5e698ba6a34dafe94d2385be4d68cc6b485489b36_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_ff8d77fba3b6a5c7217d8eb5e698ba6a34dafe94d2385be4d68cc6b485489b36->leave($__internal_ff8d77fba3b6a5c7217d8eb5e698ba6a34dafe94d2385be4d68cc6b485489b36_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_341af3491d93fec1d79e8ae5b42581bfdf81597d97ffd3a9fc454cecf92a152f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_341af3491d93fec1d79e8ae5b42581bfdf81597d97ffd3a9fc454cecf92a152f->enter($__internal_341af3491d93fec1d79e8ae5b42581bfdf81597d97ffd3a9fc454cecf92a152f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_341af3491d93fec1d79e8ae5b42581bfdf81597d97ffd3a9fc454cecf92a152f->leave($__internal_341af3491d93fec1d79e8ae5b42581bfdf81597d97ffd3a9fc454cecf92a152f_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_2ed672a29f285480cd12a369f3cd83f1c4d7165e1c0b5df31210555999f854ca = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_2ed672a29f285480cd12a369f3cd83f1c4d7165e1c0b5df31210555999f854ca->enter($__internal_2ed672a29f285480cd12a369f3cd83f1c4d7165e1c0b5df31210555999f854ca_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_2ed672a29f285480cd12a369f3cd83f1c4d7165e1c0b5df31210555999f854ca->leave($__internal_2ed672a29f285480cd12a369f3cd83f1c4d7165e1c0b5df31210555999f854ca_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block toolbar %}{% endblock %}

{% block menu %}
<span class=\"label\">
    <span class=\"icon\">{{ include('@WebProfiler/Icon/router.svg') }}</span>
    <strong>Routing</strong>
</span>
{% endblock %}

{% block panel %}
    {{ render(path('_profiler_router', { token: token })) }}
{% endblock %}
", "@WebProfiler/Collector/router.html.twig", "/Users/hugosanslaville/symfony_project/application_anem/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Collector/router.html.twig");
    }
}
