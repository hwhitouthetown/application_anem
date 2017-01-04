<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevDebugProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // stage_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'stage_homepage');
            }

            return array (  '_controller' => 'StageBundle\\Controller\\DefaultController::indexAction',  '_route' => 'stage_homepage',);
        }

        // shop_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'shop_homepage');
            }

            return array (  '_controller' => 'ShopBundle\\Controller\\DefaultController::indexAction',  '_route' => 'shop_homepage',);
        }

        // user_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'user_homepage');
            }

            return array (  '_controller' => 'UserBundle\\Controller\\DefaultController::indexAction',  '_route' => 'user_homepage',);
        }

        if (0 === strpos($pathinfo, '/co')) {
            if (0 === strpos($pathinfo, '/com')) {
                if (0 === strpos($pathinfo, '/commande')) {
                    // commande
                    if (rtrim($pathinfo, '/') === '/commande') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_commande;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'commande');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CommandeController::indexAction',  '_route' => 'commande',);
                    }
                    not_commande:

                    // commande_new
                    if ($pathinfo === '/commande/new') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_commande_new;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CommandeController::newAction',  '_route' => 'commande_new',);
                    }
                    not_commande_new:

                    // commande_show
                    if (preg_match('#^/commande/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_commande_show;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'commande_show')), array (  '_controller' => 'AppBundle\\Controller\\CommandeController::showAction',));
                    }
                    not_commande_show:

                    // commande_edit
                    if (preg_match('#^/commande/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_commande_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'commande_edit')), array (  '_controller' => 'AppBundle\\Controller\\CommandeController::editAction',));
                    }
                    not_commande_edit:

                    // commande_delete
                    if (preg_match('#^/commande/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_commande_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'commande_delete')), array (  '_controller' => 'AppBundle\\Controller\\CommandeController::deleteAction',));
                    }
                    not_commande_delete:

                    // commande_by_id_delete
                    if (0 === strpos($pathinfo, '/commande/delete') && preg_match('#^/commande/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_commande_by_id_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'commande_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\CommandeController::deleteByIdAction',));
                    }
                    not_commande_by_id_delete:

                    // commande_bulk_action
                    if ($pathinfo === '/commande/bulk-action/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_commande_bulk_action;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CommandeController::bulkAction',  '_route' => 'commande_bulk_action',);
                    }
                    not_commande_bulk_action:

                }

                if (0 === strpos($pathinfo, '/competence')) {
                    // competence
                    if (rtrim($pathinfo, '/') === '/competence') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_competence;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'competence');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::indexAction',  '_route' => 'competence',);
                    }
                    not_competence:

                    // competence_new
                    if ($pathinfo === '/competence/new') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_competence_new;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::newAction',  '_route' => 'competence_new',);
                    }
                    not_competence_new:

                    // competence_show
                    if (preg_match('#^/competence/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_competence_show;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'competence_show')), array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::showAction',));
                    }
                    not_competence_show:

                    // competence_edit
                    if (preg_match('#^/competence/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_competence_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'competence_edit')), array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::editAction',));
                    }
                    not_competence_edit:

                    // competence_delete
                    if (preg_match('#^/competence/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_competence_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'competence_delete')), array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::deleteAction',));
                    }
                    not_competence_delete:

                    // competence_by_id_delete
                    if (0 === strpos($pathinfo, '/competence/delete') && preg_match('#^/competence/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_competence_by_id_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'competence_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::deleteByIdAction',));
                    }
                    not_competence_by_id_delete:

                    // competence_bulk_action
                    if ($pathinfo === '/competence/bulk-action/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_competence_bulk_action;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CompetenceController::bulkAction',  '_route' => 'competence_bulk_action',);
                    }
                    not_competence_bulk_action:

                }

            }

            if (0 === strpos($pathinfo, '/contenu')) {
                // contenu
                if (rtrim($pathinfo, '/') === '/contenu') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_contenu;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'contenu');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\ContenuController::indexAction',  '_route' => 'contenu',);
                }
                not_contenu:

                // contenu_new
                if ($pathinfo === '/contenu/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_contenu_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\ContenuController::newAction',  '_route' => 'contenu_new',);
                }
                not_contenu_new:

                // contenu_show
                if (preg_match('#^/contenu/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_contenu_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contenu_show')), array (  '_controller' => 'AppBundle\\Controller\\ContenuController::showAction',));
                }
                not_contenu_show:

                // contenu_edit
                if (preg_match('#^/contenu/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_contenu_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contenu_edit')), array (  '_controller' => 'AppBundle\\Controller\\ContenuController::editAction',));
                }
                not_contenu_edit:

                // contenu_delete
                if (preg_match('#^/contenu/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_contenu_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contenu_delete')), array (  '_controller' => 'AppBundle\\Controller\\ContenuController::deleteAction',));
                }
                not_contenu_delete:

                // contenu_by_id_delete
                if (0 === strpos($pathinfo, '/contenu/delete') && preg_match('#^/contenu/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_contenu_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contenu_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\ContenuController::deleteByIdAction',));
                }
                not_contenu_by_id_delete:

                // contenu_bulk_action
                if ($pathinfo === '/contenu/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_contenu_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\ContenuController::bulkAction',  '_route' => 'contenu_bulk_action',);
                }
                not_contenu_bulk_action:

            }

        }

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/e')) {
            if (0 === strpos($pathinfo, '/entreprise')) {
                // entreprise
                if (rtrim($pathinfo, '/') === '/entreprise') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_entreprise;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'entreprise');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::indexAction',  '_route' => 'entreprise',);
                }
                not_entreprise:

                // entreprise_new
                if ($pathinfo === '/entreprise/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_entreprise_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::newAction',  '_route' => 'entreprise_new',);
                }
                not_entreprise_new:

                // entreprise_show
                if (preg_match('#^/entreprise/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_entreprise_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entreprise_show')), array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::showAction',));
                }
                not_entreprise_show:

                // entreprise_edit
                if (preg_match('#^/entreprise/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_entreprise_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entreprise_edit')), array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::editAction',));
                }
                not_entreprise_edit:

                // entreprise_delete
                if (preg_match('#^/entreprise/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_entreprise_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entreprise_delete')), array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::deleteAction',));
                }
                not_entreprise_delete:

                // entreprise_by_id_delete
                if (0 === strpos($pathinfo, '/entreprise/delete') && preg_match('#^/entreprise/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_entreprise_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'entreprise_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::deleteByIdAction',));
                }
                not_entreprise_by_id_delete:

                // entreprise_bulk_action
                if ($pathinfo === '/entreprise/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_entreprise_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\EntrepriseController::bulkAction',  '_route' => 'entreprise_bulk_action',);
                }
                not_entreprise_bulk_action:

            }

            if (0 === strpos($pathinfo, '/etudiant')) {
                // etudiant
                if (rtrim($pathinfo, '/') === '/etudiant') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_etudiant;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'etudiant');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::indexAction',  '_route' => 'etudiant',);
                }
                not_etudiant:

                // etudiant_new
                if ($pathinfo === '/etudiant/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_etudiant_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::newAction',  '_route' => 'etudiant_new',);
                }
                not_etudiant_new:

                // etudiant_show
                if (preg_match('#^/etudiant/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_etudiant_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'etudiant_show')), array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::showAction',));
                }
                not_etudiant_show:

                // etudiant_edit
                if (preg_match('#^/etudiant/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_etudiant_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'etudiant_edit')), array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::editAction',));
                }
                not_etudiant_edit:

                // etudiant_delete
                if (preg_match('#^/etudiant/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_etudiant_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'etudiant_delete')), array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::deleteAction',));
                }
                not_etudiant_delete:

                // etudiant_by_id_delete
                if (0 === strpos($pathinfo, '/etudiant/delete') && preg_match('#^/etudiant/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_etudiant_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'etudiant_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::deleteByIdAction',));
                }
                not_etudiant_by_id_delete:

                // etudiant_bulk_action
                if ($pathinfo === '/etudiant/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_etudiant_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\EtudiantController::bulkAction',  '_route' => 'etudiant_bulk_action',);
                }
                not_etudiant_bulk_action:

            }

        }

        if (0 === strpos($pathinfo, '/f')) {
            if (0 === strpos($pathinfo, '/faireparti')) {
                // faireparti
                if (rtrim($pathinfo, '/') === '/faireparti') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_faireparti;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'faireparti');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::indexAction',  '_route' => 'faireparti',);
                }
                not_faireparti:

                // faireparti_new
                if ($pathinfo === '/faireparti/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_faireparti_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::newAction',  '_route' => 'faireparti_new',);
                }
                not_faireparti_new:

                // faireparti_show
                if (preg_match('#^/faireparti/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_faireparti_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faireparti_show')), array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::showAction',));
                }
                not_faireparti_show:

                // faireparti_edit
                if (preg_match('#^/faireparti/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_faireparti_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faireparti_edit')), array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::editAction',));
                }
                not_faireparti_edit:

                // faireparti_delete
                if (preg_match('#^/faireparti/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_faireparti_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faireparti_delete')), array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::deleteAction',));
                }
                not_faireparti_delete:

                // faireparti_by_id_delete
                if (0 === strpos($pathinfo, '/faireparti/delete') && preg_match('#^/faireparti/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_faireparti_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faireparti_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::deleteByIdAction',));
                }
                not_faireparti_by_id_delete:

                // faireparti_bulk_action
                if ($pathinfo === '/faireparti/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_faireparti_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FairepartiController::bulkAction',  '_route' => 'faireparti_bulk_action',);
                }
                not_faireparti_bulk_action:

            }

            if (0 === strpos($pathinfo, '/fichesuivie')) {
                // fichesuivie
                if (rtrim($pathinfo, '/') === '/fichesuivie') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fichesuivie;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fichesuivie');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::indexAction',  '_route' => 'fichesuivie',);
                }
                not_fichesuivie:

                // fichesuivie_new
                if ($pathinfo === '/fichesuivie/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fichesuivie_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::newAction',  '_route' => 'fichesuivie_new',);
                }
                not_fichesuivie_new:

                // fichesuivie_show
                if (preg_match('#^/fichesuivie/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fichesuivie_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fichesuivie_show')), array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::showAction',));
                }
                not_fichesuivie_show:

                // fichesuivie_edit
                if (preg_match('#^/fichesuivie/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fichesuivie_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fichesuivie_edit')), array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::editAction',));
                }
                not_fichesuivie_edit:

                // fichesuivie_delete
                if (preg_match('#^/fichesuivie/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_fichesuivie_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fichesuivie_delete')), array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::deleteAction',));
                }
                not_fichesuivie_delete:

                // fichesuivie_by_id_delete
                if (0 === strpos($pathinfo, '/fichesuivie/delete') && preg_match('#^/fichesuivie/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fichesuivie_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fichesuivie_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::deleteByIdAction',));
                }
                not_fichesuivie_by_id_delete:

                // fichesuivie_bulk_action
                if ($pathinfo === '/fichesuivie/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fichesuivie_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FichesuivieController::bulkAction',  '_route' => 'fichesuivie_bulk_action',);
                }
                not_fichesuivie_bulk_action:

            }

        }

        if (0 === strpos($pathinfo, '/membre')) {
            // membre
            if (rtrim($pathinfo, '/') === '/membre') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_membre;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'membre');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\MembreController::indexAction',  '_route' => 'membre',);
            }
            not_membre:

            // membre_new
            if ($pathinfo === '/membre/new') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_membre_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\MembreController::newAction',  '_route' => 'membre_new',);
            }
            not_membre_new:

            // membre_show
            if (preg_match('#^/membre/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_membre_show;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'membre_show')), array (  '_controller' => 'AppBundle\\Controller\\MembreController::showAction',));
            }
            not_membre_show:

            // membre_edit
            if (preg_match('#^/membre/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_membre_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'membre_edit')), array (  '_controller' => 'AppBundle\\Controller\\MembreController::editAction',));
            }
            not_membre_edit:

            // membre_delete
            if (preg_match('#^/membre/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'DELETE') {
                    $allow[] = 'DELETE';
                    goto not_membre_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'membre_delete')), array (  '_controller' => 'AppBundle\\Controller\\MembreController::deleteAction',));
            }
            not_membre_delete:

            // membre_by_id_delete
            if (0 === strpos($pathinfo, '/membre/delete') && preg_match('#^/membre/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_membre_by_id_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'membre_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\MembreController::deleteByIdAction',));
            }
            not_membre_by_id_delete:

            // membre_bulk_action
            if ($pathinfo === '/membre/bulk-action/') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_membre_bulk_action;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\MembreController::bulkAction',  '_route' => 'membre_bulk_action',);
            }
            not_membre_bulk_action:

        }

        if (0 === strpos($pathinfo, '/p')) {
            if (0 === strpos($pathinfo, '/personnel')) {
                // personnel
                if (rtrim($pathinfo, '/') === '/personnel') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_personnel;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'personnel');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::indexAction',  '_route' => 'personnel',);
                }
                not_personnel:

                // personnel_new
                if ($pathinfo === '/personnel/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_personnel_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::newAction',  '_route' => 'personnel_new',);
                }
                not_personnel_new:

                // personnel_show
                if (preg_match('#^/personnel/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_personnel_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'personnel_show')), array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::showAction',));
                }
                not_personnel_show:

                // personnel_edit
                if (preg_match('#^/personnel/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_personnel_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'personnel_edit')), array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::editAction',));
                }
                not_personnel_edit:

                // personnel_delete
                if (preg_match('#^/personnel/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_personnel_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'personnel_delete')), array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::deleteAction',));
                }
                not_personnel_delete:

                // personnel_by_id_delete
                if (0 === strpos($pathinfo, '/personnel/delete') && preg_match('#^/personnel/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_personnel_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'personnel_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::deleteByIdAction',));
                }
                not_personnel_by_id_delete:

                // personnel_bulk_action
                if ($pathinfo === '/personnel/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_personnel_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PersonnelController::bulkAction',  '_route' => 'personnel_bulk_action',);
                }
                not_personnel_bulk_action:

            }

            if (0 === strpos($pathinfo, '/poste')) {
                // poste
                if (rtrim($pathinfo, '/') === '/poste') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_poste;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'poste');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PosteController::indexAction',  '_route' => 'poste',);
                }
                not_poste:

                // poste_new
                if ($pathinfo === '/poste/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_poste_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PosteController::newAction',  '_route' => 'poste_new',);
                }
                not_poste_new:

                // poste_show
                if (preg_match('#^/poste/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_poste_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'poste_show')), array (  '_controller' => 'AppBundle\\Controller\\PosteController::showAction',));
                }
                not_poste_show:

                // poste_edit
                if (preg_match('#^/poste/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_poste_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'poste_edit')), array (  '_controller' => 'AppBundle\\Controller\\PosteController::editAction',));
                }
                not_poste_edit:

                // poste_delete
                if (preg_match('#^/poste/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_poste_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'poste_delete')), array (  '_controller' => 'AppBundle\\Controller\\PosteController::deleteAction',));
                }
                not_poste_delete:

                // poste_by_id_delete
                if (0 === strpos($pathinfo, '/poste/delete') && preg_match('#^/poste/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_poste_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'poste_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\PosteController::deleteByIdAction',));
                }
                not_poste_by_id_delete:

                // poste_bulk_action
                if ($pathinfo === '/poste/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_poste_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PosteController::bulkAction',  '_route' => 'poste_bulk_action',);
                }
                not_poste_bulk_action:

            }

            if (0 === strpos($pathinfo, '/pro')) {
                if (0 === strpos($pathinfo, '/produit')) {
                    // produit
                    if (rtrim($pathinfo, '/') === '/produit') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_produit;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'produit');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\ProduitController::indexAction',  '_route' => 'produit',);
                    }
                    not_produit:

                    // produit_new
                    if ($pathinfo === '/produit/new') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_produit_new;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\ProduitController::newAction',  '_route' => 'produit_new',);
                    }
                    not_produit_new:

                    // produit_show
                    if (preg_match('#^/produit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_produit_show;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'produit_show')), array (  '_controller' => 'AppBundle\\Controller\\ProduitController::showAction',));
                    }
                    not_produit_show:

                    // produit_edit
                    if (preg_match('#^/produit/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_produit_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'produit_edit')), array (  '_controller' => 'AppBundle\\Controller\\ProduitController::editAction',));
                    }
                    not_produit_edit:

                    // produit_delete
                    if (preg_match('#^/produit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_produit_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'produit_delete')), array (  '_controller' => 'AppBundle\\Controller\\ProduitController::deleteAction',));
                    }
                    not_produit_delete:

                    // produit_by_id_delete
                    if (0 === strpos($pathinfo, '/produit/delete') && preg_match('#^/produit/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_produit_by_id_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'produit_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\ProduitController::deleteByIdAction',));
                    }
                    not_produit_by_id_delete:

                    // produit_bulk_action
                    if ($pathinfo === '/produit/bulk-action/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_produit_bulk_action;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\ProduitController::bulkAction',  '_route' => 'produit_bulk_action',);
                    }
                    not_produit_bulk_action:

                }

                if (0 === strpos($pathinfo, '/promotion')) {
                    // promotion
                    if (rtrim($pathinfo, '/') === '/promotion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_promotion;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'promotion');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PromotionController::indexAction',  '_route' => 'promotion',);
                    }
                    not_promotion:

                    // promotion_new
                    if ($pathinfo === '/promotion/new') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_promotion_new;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PromotionController::newAction',  '_route' => 'promotion_new',);
                    }
                    not_promotion_new:

                    // promotion_show
                    if (preg_match('#^/promotion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_promotion_show;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'promotion_show')), array (  '_controller' => 'AppBundle\\Controller\\PromotionController::showAction',));
                    }
                    not_promotion_show:

                    // promotion_edit
                    if (preg_match('#^/promotion/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_promotion_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'promotion_edit')), array (  '_controller' => 'AppBundle\\Controller\\PromotionController::editAction',));
                    }
                    not_promotion_edit:

                    // promotion_delete
                    if (preg_match('#^/promotion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_promotion_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'promotion_delete')), array (  '_controller' => 'AppBundle\\Controller\\PromotionController::deleteAction',));
                    }
                    not_promotion_delete:

                    // promotion_by_id_delete
                    if (0 === strpos($pathinfo, '/promotion/delete') && preg_match('#^/promotion/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_promotion_by_id_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'promotion_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\PromotionController::deleteByIdAction',));
                    }
                    not_promotion_by_id_delete:

                    // promotion_bulk_action
                    if ($pathinfo === '/promotion/bulk-action/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_promotion_bulk_action;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PromotionController::bulkAction',  '_route' => 'promotion_bulk_action',);
                    }
                    not_promotion_bulk_action:

                }

            }

        }

        if (0 === strpos($pathinfo, '/stage')) {
            // stage
            if (rtrim($pathinfo, '/') === '/stage') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_stage;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'stage');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\StageController::indexAction',  '_route' => 'stage',);
            }
            not_stage:

            // stage_new
            if ($pathinfo === '/stage/new') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_stage_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\StageController::newAction',  '_route' => 'stage_new',);
            }
            not_stage_new:

            // stage_show
            if (preg_match('#^/stage/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_stage_show;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'stage_show')), array (  '_controller' => 'AppBundle\\Controller\\StageController::showAction',));
            }
            not_stage_show:

            // stage_edit
            if (preg_match('#^/stage/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_stage_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'stage_edit')), array (  '_controller' => 'AppBundle\\Controller\\StageController::editAction',));
            }
            not_stage_edit:

            // stage_delete
            if (preg_match('#^/stage/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'DELETE') {
                    $allow[] = 'DELETE';
                    goto not_stage_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'stage_delete')), array (  '_controller' => 'AppBundle\\Controller\\StageController::deleteAction',));
            }
            not_stage_delete:

            // stage_by_id_delete
            if (0 === strpos($pathinfo, '/stage/delete') && preg_match('#^/stage/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_stage_by_id_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'stage_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\StageController::deleteByIdAction',));
            }
            not_stage_by_id_delete:

            // stage_bulk_action
            if ($pathinfo === '/stage/bulk-action/') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_stage_bulk_action;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\StageController::bulkAction',  '_route' => 'stage_bulk_action',);
            }
            not_stage_bulk_action:

        }

        if (0 === strpos($pathinfo, '/u')) {
            if (0 === strpos($pathinfo, '/user')) {
                // user
                if (rtrim($pathinfo, '/') === '/user') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'user');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::indexAction',  '_route' => 'user',);
                }
                not_user:

                // user_new
                if ($pathinfo === '/user/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_user_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::newAction',  '_route' => 'user_new',);
                }
                not_user_new:

                // user_show
                if (preg_match('#^/user/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_show')), array (  '_controller' => 'AppBundle\\Controller\\UserController::showAction',));
                }
                not_user_show:

                // user_edit
                if (preg_match('#^/user/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_user_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_edit')), array (  '_controller' => 'AppBundle\\Controller\\UserController::editAction',));
                }
                not_user_edit:

                // user_delete
                if (preg_match('#^/user/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_user_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_delete')), array (  '_controller' => 'AppBundle\\Controller\\UserController::deleteAction',));
                }
                not_user_delete:

                // user_by_id_delete
                if (0 === strpos($pathinfo, '/user/delete') && preg_match('#^/user/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\UserController::deleteByIdAction',));
                }
                not_user_by_id_delete:

                // user_bulk_action
                if ($pathinfo === '/user/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_user_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::bulkAction',  '_route' => 'user_bulk_action',);
                }
                not_user_bulk_action:

            }

            if (0 === strpos($pathinfo, '/utilisateur')) {
                // utilisateur
                if (rtrim($pathinfo, '/') === '/utilisateur') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_utilisateur;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'utilisateur');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::indexAction',  '_route' => 'utilisateur',);
                }
                not_utilisateur:

                // utilisateur_new
                if ($pathinfo === '/utilisateur/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_utilisateur_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::newAction',  '_route' => 'utilisateur_new',);
                }
                not_utilisateur_new:

                // utilisateur_show
                if (preg_match('#^/utilisateur/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_utilisateur_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'utilisateur_show')), array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::showAction',));
                }
                not_utilisateur_show:

                // utilisateur_edit
                if (preg_match('#^/utilisateur/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_utilisateur_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'utilisateur_edit')), array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::editAction',));
                }
                not_utilisateur_edit:

                // utilisateur_delete
                if (preg_match('#^/utilisateur/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_utilisateur_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'utilisateur_delete')), array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::deleteAction',));
                }
                not_utilisateur_delete:

                // utilisateur_by_id_delete
                if (0 === strpos($pathinfo, '/utilisateur/delete') && preg_match('#^/utilisateur/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_utilisateur_by_id_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'utilisateur_by_id_delete')), array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::deleteByIdAction',));
                }
                not_utilisateur_by_id_delete:

                // utilisateur_bulk_action
                if ($pathinfo === '/utilisateur/bulk-action/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_utilisateur_bulk_action;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UtilisateurController::bulkAction',  '_route' => 'utilisateur_bulk_action',);
                }
                not_utilisateur_bulk_action:

            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/conten')) {
                // api_get_contenu
                if (0 === strpos($pathinfo, '/api/contenu') && preg_match('#^/api/contenu(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_get_contenu;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_contenu')), array (  '_controller' => 'AppBundle\\Controller\\ApiController::getContenuAction',  '_format' => 'json',));
                }
                not_api_get_contenu:

                // api_get_conten
                if (0 === strpos($pathinfo, '/api/contens') && preg_match('#^/api/contens/(?P<id>[^/\\.]++)(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_get_conten;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_conten')), array (  '_controller' => 'AppBundle\\Controller\\ApiController::getContenAction',  '_format' => 'json',));
                }
                not_api_get_conten:

            }

            if (0 === strpos($pathinfo, '/api/index')) {
                // api_user_index
                if (preg_match('#^/api/index(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_user_index;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_user_index')), array (  '_controller' => 'UserBundle\\Controller\\DefaultController::indexAction',  '_format' => 'json',));
                }
                not_api_user_index:

                // api_stage_index
                if (preg_match('#^/api/index(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_stage_index;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_stage_index')), array (  '_controller' => 'StageBundle\\Controller\\DefaultController::indexAction',  '_format' => 'json',));
                }
                not_api_stage_index:

            }

            if (0 === strpos($pathinfo, '/api/shop')) {
                // api_shop_index
                if (0 === strpos($pathinfo, '/api/shop/index') && preg_match('#^/api/shop/index(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_shop_index;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_shop_index')), array (  '_controller' => 'ShopBundle\\Controller\\DefaultController::indexAction',  '_format' => 'json',));
                }
                not_api_shop_index:

                // api_shop_get_produit
                if (0 === strpos($pathinfo, '/api/shop/produit') && preg_match('#^/api/shop/produit(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_shop_get_produit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_shop_get_produit')), array (  '_controller' => 'ShopBundle\\Controller\\DefaultController::getProduitAction',  '_format' => 'json',));
                }
                not_api_shop_get_produit:

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
