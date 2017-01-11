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

        // nelmio_api_doc_index
        if (0 === strpos($pathinfo, '/api/doc') && preg_match('#^/api/doc(?:/(?P<view>[^/]++))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_nelmio_api_doc_index;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'nelmio_api_doc_index')), array (  '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  'view' => 'default',));
        }
        not_nelmio_api_doc_index:

        // fos_oauth_server_token
        if ($pathinfo === '/oauth/v2/token') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_oauth_server_token;
            }

            return array (  '_controller' => 'fos_oauth_server.controller.token:tokenAction',  '_route' => 'fos_oauth_server_token',);
        }
        not_fos_oauth_server_token:

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

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
