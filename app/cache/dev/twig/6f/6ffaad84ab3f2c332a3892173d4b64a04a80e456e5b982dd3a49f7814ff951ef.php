<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_6b70bad961f76aaefae19374cd040fe76a61f73fd00c59d08d41c2427bdb4806 extends Twig_Template
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
        $__internal_6949e048c06ea2484dab90878070f0b992642d00cdf9cd126133497c94c3277d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6949e048c06ea2484dab90878070f0b992642d00cdf9cd126133497c94c3277d->enter($__internal_6949e048c06ea2484dab90878070f0b992642d00cdf9cd126133497c94c3277d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_6949e048c06ea2484dab90878070f0b992642d00cdf9cd126133497c94c3277d->leave($__internal_6949e048c06ea2484dab90878070f0b992642d00cdf9cd126133497c94c3277d_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_613a36fb6d7b10aa1fd28e8ba1d69da616132fd050e898f5dd9077469d0955c7 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_613a36fb6d7b10aa1fd28e8ba1d69da616132fd050e898f5dd9077469d0955c7->enter($__internal_613a36fb6d7b10aa1fd28e8ba1d69da616132fd050e898f5dd9077469d0955c7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_613a36fb6d7b10aa1fd28e8ba1d69da616132fd050e898f5dd9077469d0955c7->leave($__internal_613a36fb6d7b10aa1fd28e8ba1d69da616132fd050e898f5dd9077469d0955c7_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_4613938f01469771bd20fd4e8a191584617b7942b900042909a897c0951132fa = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_4613938f01469771bd20fd4e8a191584617b7942b900042909a897c0951132fa->enter($__internal_4613938f01469771bd20fd4e8a191584617b7942b900042909a897c0951132fa_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_4613938f01469771bd20fd4e8a191584617b7942b900042909a897c0951132fa->leave($__internal_4613938f01469771bd20fd4e8a191584617b7942b900042909a897c0951132fa_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_9ef1a515e1be81bef1ba35db5e6c242bdcd2ee0fe30412e4ae87c1cb0bdfdfe3 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9ef1a515e1be81bef1ba35db5e6c242bdcd2ee0fe30412e4ae87c1cb0bdfdfe3->enter($__internal_9ef1a515e1be81bef1ba35db5e6c242bdcd2ee0fe30412e4ae87c1cb0bdfdfe3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_9ef1a515e1be81bef1ba35db5e6c242bdcd2ee0fe30412e4ae87c1cb0bdfdfe3->leave($__internal_9ef1a515e1be81bef1ba35db5e6c242bdcd2ee0fe30412e4ae87c1cb0bdfdfe3_prof);

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
", "@WebProfiler/Collector/router.html.twig", "/var/www/html/application_anem/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Collector/router.html.twig");
    }
}
