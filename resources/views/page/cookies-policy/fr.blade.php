@extends('layouts.app')

@section('title', 'Politique en matière de cookies')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3">
                <h1>Politique en matière de cookies</h1>
            </div>
            <div class="col-12 col-lg font-lg">

                <section class="mb-5">
                    <h5><strong>a) Définition</strong></h5>
                    <p>Un cookie est un fichier qui est téléchargé sur votre ordinateur/smartphone/tablette lorsque vous accédez à certains sites web. Les cookies permettent à un site web, entre autres, de stocker et de récupérer des informations sur les habitudes de navigation d’un utilisateur ou de son dispositif et, selon les informations qu’ils contiennent et la façon dont vous utilisez votre dispositif, ils peuvent être utilisés pour reconnaître l’utilisateur.</p>
                    <p>Il est possible de classer les cookies selon le but pour lequel ils sont conçus, notamment:</p>
                    <ul>
                        <li><i>Cookies techniques</i>: ils permettent à l’utilisateur de naviguer sur un site web, une plateforme ou une application et d’utiliser différentes options ou services qui existent sur ceux-ci comme, par exemple, le contrôle du trafic et de la communication des données, l’identification de la session, l’accès à des parties d’accès restreint, la mémorisation des éléments qui composent une commande, le processus d’achat d’une commande, la demande d’inscription ou la participation à un événement, l’utilisation des fonctions de sécurité pendant la navigation, le stockage de contenus pour la diffusion de vidéos ou de sons ou le partage de contenus via les réseaux sociaux.</li>
                        <li><i>Cookies de personnalisation</i>: ils permettent à l’utilisateur d’accéder au service avec certaines caractéristiques générales prédéfinies en fonction d’une série de critères du terminal de l’utilisateur, tels que la langue, le type de navigateur utilisé pour accéder au service, la configuration régionale depuis laquelle on accède au service, etc.</li>
                        <li><i>Cookies d’analyse</i>: ces cookies permettent à leur responsable de suivre et d’analyser le comportement des utilisateurs des sites web auxquels ils sont liés. Les informations recueillies par ce type de cookies sont utilisées pour mesurer l’activité des sites web, de l’application ou de la plateforme et pour l’élaboration de profils de navigation des utilisateurs de ces sites, applications et plateformes, afin d’introduire des améliorations basées sur l’analyse des données d’utilisation des utilisateurs du service.</li>
                        <li><i>Cookies publicitaires</i>: ils permettent de gérer, de la manière la plus efficace possible, les espaces publicitaires que l’éditeur, le cas échéant, a inclus sur un site web, une application ou une plateforme à partir de laquelle le service demandé est fourni, en fonction de critères tels que le contenu édité ou la fréquence à laquelle les publicités sont affichées.</li>
                        <li><i>Cookies de publicité comportementale</i>: ils permettent de gérer, de la manière la plus efficace possible, les espaces publicitaires que l’éditeur, le cas échéant, a inclus sur un site web, une application ou une plateforme à partir desquels le service demandé est fourni. Ces cookies stockent des informations sur le comportement des utilisateurs obtenues par l’observation continue de leurs habitudes de navigation, ce qui permet de développer un profil spécifique afin d’afficher des publicités basées sur ce dernier.</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h5><strong>b) Configuration sur mon dispositif</strong></h5>
                    @if ($consent && count($consent['level']) > 1)
                        <p>Votre statut actuel: autoriser les cookies {{ implode(',', $types) }}. <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><u>Modifier votre consentement</u></a>.</p>
                    @else
                        <p>Votre statut actuel: utiliser uniquement les cookies nécessaires. <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><u>Modifier votre consentement</u></a>.</p>
                    @endif
                </section>

                <section class="mb-5">
                    <h5><strong>c) Types de cookies sur ce site web</strong></h5>
                    <table class="table font-sm">
                        <thead>
                            <tr>
                                <th>Propre/Tiers</th>
                                <th>Objectif</th>
                                <th>Nom du cookie</th>
                                <th>Description de l’objectif</th>
                                <th>Expiration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Propre</td>
                                <td>Technique</td>
                                <td>
                                    common_lands_network_session
                                </td>
                                <td>Identifie l’utilisateur et permet l’authentification avec le serveur</td>
                                <td>30 jours</td>
                            </tr>
                            <tr>
                                <td>Propre</td>
                                <td>Technique</td>
                                <td>
                                    XSRF-TOKEN
                                </td>
                                <td>écurité XSS pour l’envoi de formulaires</td>
                                <td>30 jours</td>
                            </tr>
                            <tr>
                                <td>Propre</td>
                                <td>Technique</td>
                                <td>
                                    cc_cookie
                                </td>
                                <td>Stocker la configuration de cookies</td>
                                <td>180 jours</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mb-5">
                    <h5><strong>d) Comment peut-on désactiver ou éliminer ces cookies sur les navigateurs?</strong></h5>
                    <p>
                        En cliquant sur un lien sur ce site web, des cookies peuvent être installés. Lorsque vous quittez cette page, veuillez consulter la politique en matière de cookies de ces sites.
                        <br>L’utilisateur peut – à tout moment – choisir les cookies qu’il souhaite exploiter sur ce site web selon:
                    </p>
                    <ul>
                        <li>
                            la configuration du <strong>navigateur</strong>; par exemple:
                            <ul>
                                <li><strong>Chrome</strong>: <a href="http://support.google.com/chrome/bin/answer.py?hl=fr&answer=95647" target="_blank" rel="noopener noreferrer">http://support.google.com/chrome/bin/answer.py?hl=fr&answer=95647</a></li>
                                <li><strong>Explorer</strong>: <a href="http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9" target="_blank" rel="noopener noreferrer">http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9</a></li>
                                <li><strong>Firefox</strong>: <a href="http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we" target="_blank" rel="noopener noreferrer">http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we</a></li>
                                <li><strong>Safari</strong>: <a href="http://support.apple.com/kb/ph5042" target="_blank" rel="noopener noreferrer">http://support.apple.com/kb/ph5042</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h5><strong>e) Que se passe-t-il si vous désactivez les cookies</strong></h5>
                    <p>Certaines fonctionnalités des services seront désactivées.</p>
                </section>

            </div>
        </div>
    </div>

@endsection
