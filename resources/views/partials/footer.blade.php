<div id="loading">
    <img src="{{ url('/images/loading.svg') }}" alt="" srcset="">
</div>

<div id="consent-cookies-mini">
    <a href="javascript:void(0);" aria-label="View cookie settings" data-cc="c-settings"><i class="fas fa-cog pr-2"></i>{{ __('Configurar cookies') }}</a>
</div>

<script src="{{ url('js/modernizr-custom.js') }}?v=3.7.1-cs1"></script>
<script src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.4.7/dist/cookieconsent.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.full.min.js" integrity="sha256-/IUDRcglIrROpUfaxqKxg4kthVduVKB0mvd7PwtlmAk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.4/b-html5-1.5.4/datatables.min.js"></script>

<!-- Conditionize2.js -->
<script src="https://cdn.jsdelivr.net/npm/conditionize2@2.0.1/jquery.conditionize2.min.js" integrity="sha256-vMy8obxbABHz/tsk4/YrDbtlyKa22SxcAkFtZlfbV5E=" crossorigin="anonymous"></script>

<script>
    moment.locale('{{ locale(true) }}');

    var datatables_ops = {
        dom: "<'row'<'col-auto ml-auto'p>>" +
             "<'row'<'col-12't><'m-auto py-5'r>>",
        lengthMenu: [[8], [8]],
        pagingType: 'numbers',
        processing: true,
        language: {
            paginate: {
                previous: '<',
                next: '>'
            },
            sZeroRecords: '{{ __('No se han encontrado resultados') }}'
        }
    };

    @if ('/backend' === Route::getCurrentRoute()->getPrefix())
        datatables_ops.lengthMenu = [[15, 50, 100, -1], [15, 50, 100, 'Todos']];
    @endif

    var summernote_ops = {
        lang: '{{ locale() }}',
        theme: 'default',
        toolbar: [
            // ['style', ['style']],
            ['font', ['bold', 'italic']],
            ['insert', ['link']],
        ]
    };

    var dropzone_ops = {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        params: { id: '{{ uniqid() }}' },
        uploadMultiple: false,
        parallelUploads: 1,
        addRemoveLinks: true,
        dictRemoveFile: '{{ __('Eliminar archivo') }}',
        dictFileTooBig: '{{ __('El archivo es mayor de :size MB', ['size' => '\{\{maxFilesize\}\}']) }}',
        dictMaxFilesExceeded: '{{ __('Solo puede añadir un máximo de :files archivos', ['files' => '\{\{maxFiles\}\}']) }}',
        timeout: 10000,
        thumbnailWidth: 200,
        thumbnailHeight: 200,
        error: function (file, res, d) {
            var error = '';
            if (res.errors) {
                for (const key in res.errors) {
                    error = res.errors[key][0];
                }
            }
            var error = (error) ? error : ((res.message) ? res.message : res);
            $(file.previewElement).addClass('dz-error').find('.dz-error-message span').html(error);
        },
    }

    $(function () {
        $('.select2').select2().on('select2:unselect', function (e) {
            if (! e.params.originalEvent) {
                return;
            }

            e.params.originalEvent.stopPropagation();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.btn-lang').click(function (e, lang) {
            e.preventDefault();

            lang = lang || $(this).data('lang');
            $('.lang').not(':lang(' + lang + ')').hide();
            $('.lang:lang(' + lang + ')').show();
            // Button
            $('.btn-lang').each(function (index, item) {
                $(this).toggleClass('active', $(this).data('lang') == lang);
            });
        }).trigger('click', ['{{ app()->getLocale() }}']);

        $('.date-readonly').each(function (index, elem) {
            if (! $(elem).val().length) {
                return;
            }
            var value = moment($(elem).val()).format('L');
            $(elem).val(value);
        });
    });

    var cookieconsent = initCookieConsent();

    cookieconsent.run({
        current_lang: '{{ strtolower(locale(true)) }}',
        autoclear_cookies: true,

        onAccept: function(cookies) {
            if (cookieconsent.allowedCategory('necessary')) {
                $('#consent-cookies-mini').addClass('show');
            }
        },

        languages: {
            es: {
                consent_modal: {
                    title: '',
                    description: '<i>En</i> Iniciativa Comunales <i>utilizamos cookies propias y de terceros</i> que permiten al usuario la navegación a través de una página web <strong>(técnicas)</strong>. Si acepta este aviso consideraremos que acepta su uso. Puede obtener más información, o bien conocer cómo cambiar la configuración, en nuestra <a href="/cookies-policy" class="cc-link">Política de cookies</a>.<br><br><button type="button" data-cc="c-settings" class="cc-link"><i class="fas fa-cog pr-2"></i>Configurar cookies</button>.',
                    primary_btn: {
                        text: 'Aceptar',
                        role: 'accept_all'  //'accept_selected' or 'accept_all'
                    },
                    secondary_btn: {
                        text: 'Rechazar',
                        role: 'accept_necessary'   //'settings' or 'accept_necessary'
                    },
                },
                settings_modal: {
                    title: 'Configurar cookies',
                    save_settings_btn: 'Guardar',
                    accept_all_btn: 'Aceptar todas las cookies',
                    close_btn_label: 'Cerrar',
                    cookie_table_headers : [
                        { col1: 'Nombre' },
                        { col2: 'Dominio' },
                        { col3: 'Expiración' },
                        { col4: 'Descripción' },
                    ],
                    blocks: [
                        {
                            title: '',
                            description: 'Utilizamos cookies para garantizar las funcionalidades básicas del sitio web y para mejorar su experiencia en línea. Puede optar por participar o no participar en cada categoría cuando lo desee. Para obtener más detalles sobre las cookies y otros datos confidenciales, lea la <a href="/privacy-policy" class="cc-link">política de privacidad general</a>.'
                        },{
                            title: 'Técnicas o necesarias',
                            description: 'Estas cookies son necesarias para que el sitio web funcione y no se pueden desactivar en nuestros sistemas. Para utilizar este sitio web utilizamos las siguientes cookies técnicamente requeridas.',
                            toggle: {
                                value: 'necessary',
                                enabled: true,
                                readonly: true
                            },
                            cookie_table: [
                                {
                                    col1: 'common_lands_network_session',
                                    col2: 'commonlandsnet.org',
                                    col3: '30 días',
                                    col4: 'Identificación del usuario'
                                },
                                {
                                    col1: 'XSRF-TOKEN',
                                    col2: 'commonlandsnet.org',
                                    col3: '30 días',
                                    col4: 'Seguridad XSS para envío de formularios'
                                },
                                {
                                    col1: 'cc_cookie',
                                    col2: 'commonlandsnet.org',
                                    col3: '180 días',
                                    col4: 'Almacenar configuración de cookies'
                                }
                            ]
                        },
                    ]
                }
            },
            en: {
                consent_modal: {
                    title: '',
                    description: 'Common Lands Network uses our own cookies and those of third parties, which allows users to browse through a webpage <strong>(technical)</strong>. By accepting this notice, you are accepting our use of cookies. For more information or to find out how to change the configuration, see our <a href="/cookies-policy" class="cc-link">Cookies policy</a>.<br><br><button type="button" data-cc="c-settings" class="cc-link"><i class="fas fa-cog pr-2"></i>Configure cookies</button>.',
                    primary_btn: {
                        text: 'Accept',
                        role: 'accept_all'  //'accept_selected' or 'accept_all'
                    },
                    secondary_btn: {
                        text: 'Reject',
                        role: 'accept_necessary'   //'settings' or 'accept_necessary'
                    },
                },
                settings_modal: {
                    title: 'Configure cookies',
                    save_settings_btn: 'Save',
                    accept_all_btn: 'Accept all cookies',
                    close_btn_label: 'Close',
                    cookie_table_headers : [
                        { col1: 'Name' },
                        { col2: 'Domain' },
                        { col3: 'Duration' },
                        { col4: 'Description' },
                    ],
                    blocks: [
                        {
                            title: '',
                            description: 'We use cookies to guarantee the proper basic functioning of the website and to improve your online experience. You can choose to participate or not in each category whenever you want. For more details on cookies and other confidential data, see the <a href="/privacy-policy" class="cc-link">general privacy policy</a>.'
                        },{
                            title: 'Technical or necessary cookies',
                            description: 'These cookies are necessary for the website to function properly and cannot be disabled on our systems. This website uses the following technically required cookies.',
                            toggle: {
                                value: 'necessary',
                                enabled: true,
                                readonly: true
                            },
                            cookie_table: [
                                {
                                    col1: 'common_lands_network_session',
                                    col2: 'commonlandsnet.org',
                                    col3: '30 days',
                                    col4: 'User identification'
                                },
                                {
                                    col1: 'XSRF-TOKEN',
                                    col2: 'commonlandsnet.org',
                                    col3: '30 days',
                                    col4: 'XSS security for form submission'
                                },
                                {
                                    col1: 'cc_cookie',
                                    col2: 'commonlandsnet.org',
                                    col3: '180 days',
                                    col4: 'Cookie storage configuration'
                                }
                            ]
                        },
                    ]
                }
            },
            fr: {
                consent_modal: {
                    title: '',
                    description: 'Iniciativa Comunales <i>utilise des cookies propres et de tiers</i> qui permettent à l’utilisateur de naviguer sur une page web <strong>(techniques)</strong>. Si vous acceptez cet avis, nous considérerons que vous acceptez leur utilisation. Vous pouvez obtenir des informations supplémentaires ou savoir comment modifier la configuration dans notre <a href="/cookies-policy" class="cc-link">Politique de confidentialité</a>.<br><br><button type="button" data-cc="c-settings" class="cc-link"><i class="fas fa-cog pr-2"></i>Configurer Cookies</button>.',
                    primary_btn: {
                        text: 'Accepter',
                        role: 'accept_all'  //'accept_selected' or 'accept_all'
                    },
                    secondary_btn: {
                        text: 'Refuser',
                        role: 'accept_necessary'   //'settings' or 'accept_necessary'
                    },
                },
                settings_modal: {
                    title: 'Configurer cookies',
                    save_settings_btn: 'Sauvegarder',
                    accept_all_btn: 'Accepter tous les cookies',
                    close_btn_label: 'Fermer',
                    cookie_table_headers : [
                        { col1: 'Nom' },
                        { col2: 'Domaine' },
                        { col3: 'Expiration' },
                        { col4: 'Description' },
                    ],
                    blocks: [
                        {
                            title: '',
                            description: 'Nous utilisons des cookies pour garantir les fonctionnalités de base du site web et pour améliorer votre expérience en ligne. Vous pouvez choisir de participer ou non dans chaque catégorie quand vous le souhaitez. Pour plus de détails sur les cookies et autres données confidentielles, lisez la <a href="/privacy-policy" class="cc-link">politique générale de confidentialité</a>.'
                        },{
                            title: 'Techniques ou nécessaire',
                            description: 'Ces cookies sont nécessaire pour que le site web fonctionne et ne peuvent pas être désactivés sur nos systèmes. Pour utiliser ce site web nous utilisons les cookies suivants techniquement nécessaires.',
                            toggle: {
                                value: 'necessary',
                                enabled: true,
                                readonly: true
                            },
                            cookie_table: [
                                {
                                    col1: 'common_lands_network_session',
                                    col2: 'commonlandsnet.org',
                                    col3: '30 jours',
                                    col4: 'Identification de l’utilisateur'
                                },
                                {
                                    col1: 'XSRF-TOKEN',
                                    col2: 'commonlandsnet.org',
                                    col3: '30 jours',
                                    col4: 'Sécurité XSS pour envoi de formulaires'
                                },
                                {
                                    col1: 'cc_cookie',
                                    col2: 'commonlandsnet.org',
                                    col3: '180 jours',
                                    col4: 'Stocker configuration de cookies'
                                }
                            ]
                        },
                    ]
                }
            }
        }
    });

</script>
