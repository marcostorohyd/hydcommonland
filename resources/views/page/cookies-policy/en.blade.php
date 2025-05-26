@extends('layouts.app')

@section('title', 'Cookies policy')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3">
                <h1>Cookies policy</h1>
            </div>
            <div class="col-12 col-lg font-lg">

                <section class="mb-5">
                    <h5><strong>a) Definition</strong></h5>
                    <p>A cookie is a small text file that is downloaded onto your computer/smartphone/tablet when you visit certain websites. Among other things, cookies allow a website to store and retrieve the  browsing information of a user or computer and, depending on the information they contain and the way in which the computer is used, they can be used to recognize the user.</p>
                    <p>Cookies can be classified by their intended purposes, and there are several types:</p>
                    <ul>
                        <li><strong>Technical cookies</strong>: Technical cookies allow the user to browse a website, platform or app to use the provided options and services, such as controlling data traffic and communication, identifying the session, visiting restricted-access areas, remembering the elements that make up an order, placing an order, registering for or participating in an event, using safety features while browsing, storing content for video or sound streaming or for sharing on social networks.</li>
                        <li><strong>Personalization cookies</strong>: Personalization cookies allow the user to access web services with certain predefined elements, established through a series of criteria on the user’s computer; these may include language preferences, the type of browser used to access services, the regional configuration from where the service is accessed, etc. </li>
                        <li><strong>Analytical cookies</strong>: Analytical cookies allow the webiste to track and analyse information on how users visit the various pages on the site. The data collected through this type of cookie is used to measure activity on the web page, application or platform and to construct user profiles for the visitors of said pages, applications and platforms, in order to improve the data analysis of how the users use the site.</li>
                        <li><strong>Advertising cookies</strong>: Advertising cookies make it possible to manage, as efficiently as possible, the advertising spaces that, where applicable, the editor has included on a website, application or platform from which the requested service is offered, on the basis of criteria like the edited content or the frequency with which advertisements are shown. </li>
                        <li><strong>Behavioural advertising cookies</strong>: Behavioural advertising cookies make it possible to manage, as efficiently as possible, the advertising spaces that, where applicable, the editor has included on a website, application or platform from which the requested service is offered. These cookies store information on user behaviour, obtained from continuously observing their browsing habits, which makes it possible to develop a specific profile to display advertising accordingly.</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h5><strong>b) Configuration on my computer</strong></h5>
                    @if ($consent && count($consent['level']) > 1)
                        <p>Your current status: Allow cookies {{ implode(',', $types) }}. <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><u>Change your consent</u></a>.</p>
                    @else
                        <p>Your current status: Only use necessary cookies. <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><u>Change your consent</u></a>.</p>
                    @endif
                </section>

                <section class="mb-5">
                    <h5><strong>c) Types of cookies on this website</strong></h5>
                    <table class="table font-sm">
                        <thead>
                            <tr>
                                <th>Own/Third Party</th>
                                <th>Purpose</th>
                                <th>Name of cookie</th>
                                <th>Description of the purpose</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Own</td>
                                <td>Technical</td>
                                <td>
                                    common_lands_network_session
                                </td>
                                <td>Identify the user and allow server authentication</td>
                                <td>30 days</td>
                            </tr>
                            <tr>
                                <td>Own</td>
                                <td>Technical</td>
                                <td>
                                    XSRF-TOKEN
                                </td>
                                <td>XSS security for form submission</td>
                                <td>30 days</td>
                            </tr>
                            <tr>
                                <td>Own</td>
                                <td>Technical</td>
                                <td>
                                    cc_cookie
                                </td>
                                <td>Cookie storage configuration</td>
                                <td>180 days</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mb-5">
                    <h5><strong>d) How can I disable or delete these cookies on the browsers?</strong></h5>
                    <p>
                        When you click on a link on this website, cookies may be installed. After you leave this page, review the cookies policies on those sites.
                        <br>Users can choose the cookies they want to operate on the website at any time by:
                    </p>
                    <ul>
                        <li>
                            Configuring the <strong>browser</strong>, for example:
                            <ul>
                                <li><strong>Chrome</strong>, <a href="http://support.google.com/chrome/bin/answer.py?hl=en&answer=95647" target="_blank" rel="noopener noreferrer">http://support.google.com/chrome/bin/answer.py?hl=en&answer=95647</a></li>
                                <li><strong>Explorer</strong>, <a href="http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9" target="_blank" rel="noopener noreferrer">http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9</a></li>
                                <li><strong>Firefox</strong>, <a href="http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we" target="_blank" rel="noopener noreferrer">http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we</a></li>
                                <li><strong>Safari</strong>, <a href="http://support.apple.com/kb/ph5042" target="_blank" rel="noopener noreferrer">http://support.apple.com/kb/ph5042</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h5><strong>e) What happens if I disable cookies?</strong></h5>
                    <p>Some functionalities of the services will be disabled.</p>
                </section>

            </div>
        </div>
    </div>

@endsection
