@extends('layouts.app')

@section('title', 'Política de cookies')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3">
                <h1>Política de cookies</h1>
            </div>
            <div class="col-12 col-lg font-lg">

                <section class="mb-5">
                    <h5><strong>a) Definición</strong></h5>
                    <p>Una cookie es un fichero que se descarga en su ordenador/ smartphone/ tablet al acceder a determinadas páginas web. Las cookies permiten a una página web, entre otras cosas, almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo y, dependiendo de la información que contengan y de la forma en que utilice su equipo, pueden utilizarse para reconocer al usuario.</p>
                    <p>Una de las clasificaciones que se puede hacer de las cookies es sobre la finalidad a la que se destinan, así tenemos varios tipos:</p>
                    <ul>
                        <li><i>Cookies técnicas</i>: Son aquéllas que permiten al usuario la navegación a través de una página web, plataforma o aplicación y la utilización de las diferentes opciones o servicios que en ella existan como, por ejemplo, controlar el tráfico y la comunicación de datos, identificar la sesión, acceder a partes de acceso restringido, recordar los elementos que integran un pedido, realizar el proceso de compra de un pedido, realizar la solicitud de inscripción o participación en un evento, utilizar elementos de seguridad durante la navegación, almacenar contenidos para la difusión de videos o sonido o compartir contenidos a través de redes sociales.</li>
                        <li><i>Cookies de personalización</i>: Son aquéllas que permiten al usuario acceder al servicio con algunas características de carácter general predefinidas en función de una serie de criterios en el terminal del usuario como por ejemplo serian el idioma, el tipo de navegador a través del cual accede al servicio, la configuración regional desde donde accede al servicio, etc.</li>
                        <li><i>Cookies de análisis</i>: Son aquéllas que permiten al responsable de las mismas, el seguimiento y análisis del comportamiento de los usuarios de los sitios web a los que están vinculadas. La información recogida mediante este tipo de cookies se utiliza en la medición de la actividad de los sitios web, aplicación o plataforma y para la elaboración de perfiles de navegación de los usuarios de dichos sitios, aplicaciones y plataformas, con el fin de introducir mejoras en función del análisis de los datos de uso que hacen los usuarios del servicio.</li>
                        <li><i>Cookies publicitarias</i>: Son aquéllas que permiten la gestión, de la forma más eficaz posible, de los espacios publicitarios que, en su caso, el editor haya incluido en una página web, aplicación o plataforma desde la que presta el servicio solicitado en base a criterios como el contenido editado o la frecuencia en la que se muestran los anuncios.</li>
                        <li><i>Cookies de publicidad comportamental</i>: Son aquéllas que permiten la gestión, de la forma más eficaz posible, de los espacios publicitarios que, en su caso, el editor haya incluido en una página web, aplicación o plataforma desde la que presta el servicio solicitado. Estas cookies almacenan información del comportamiento de los usuarios obtenida a través de la observación continuada de sus hábitos de navegación, lo que permite desarrollar un perfil específico para mostrar publicidad en función del mismo.</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h5><strong>b) Configuración en mi equipo</strong></h5>
                    @if ($consent && count($consent['level']) > 1)
                        <p>Su estado actual: Permitir cookies {{ implode(',', $types) }}. <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><u>Cambiar su consentimiento</u></a>.</p>
                    @else
                        <p>Su estado actual: Solo usar cookies necesarias. <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><u>Cambiar su consentimiento</u></a>.</p>
                    @endif
                </section>

                <section class="mb-5">
                    <h5><strong>c) Tipos de cookies en esta web</strong></h5>
                    <table class="table font-sm">
                        <thead>
                            <tr>
                                <th>Propia/Tercero</th>
                                <th>Finalidad</th>
                                <th>Nombre de la cookie</th>
                                <th>Descripción de la finalidad</th>
                                <th>Caducidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Propia</td>
                                <td>Técnica</td>
                                <td>
                                    common_lands_network_session
                                </td>
                                <td>Identifica al usuario y permite la autenticación con el servidor</td>
                                <td>30 días</td>
                            </tr>
                            <tr>
                                <td>Propia</td>
                                <td>Técnica</td>
                                <td>
                                    XSRF-TOKEN
                                </td>
                                <td>Seguridad XSS para envío de formularios</td>
                                <td>30 días</td>
                            </tr>
                            <tr>
                                <td>Propia</td>
                                <td>Técnica</td>
                                <td>
                                    cc_cookie
                                </td>
                                <td>Almacenar configuración de cookies</td>
                                <td>180 días</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mb-5">
                    <h5><strong>d) ¿Cómo puedo desactivar o eliminar estas cookies en los navegadores?</strong></h5>
                    <p>
                        Al clicar en algún enlace de esta web se pueden instalar cookies. Una vez abandone esta página, revise la política de cookies de esos sitios.
                        <br>El usuario podrá -en cualquier momento- elegir qué cookies quiere que funcionen en este sitio web mediante:
                    </p>
                    <ul>
                        <li>
                            la configuración del <strong>navegador</strong>; por ejemplo:
                            <ul>
                                <li><strong>Chrome</strong>, desde <a href="http://support.google.com/chrome/bin/answer.py?hl=es&answer=95647" target="_blank" rel="noopener noreferrer">http://support.google.com/chrome/bin/answer.py?hl=es&answer=95647</a></li>
                                <li><strong>Explorer</strong>, desde <a href="http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9" target="_blank" rel="noopener noreferrer">http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9</a></li>
                                <li><strong>Firefox</strong>, desde <a href="http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we" target="_blank" rel="noopener noreferrer">http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we</a></li>
                                <li><strong>Safari</strong>, desde <a href="http://support.apple.com/kb/ph5042" target="_blank" rel="noopener noreferrer">http://support.apple.com/kb/ph5042</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h5><strong>e) Qué ocurre si se deshabilitan las Cookies</strong></h5>
                    <p>Algunas funcionalidades de los servicios quedarán deshabilitadas.</p>
                </section>

            </div>
        </div>
    </div>

@endsection
