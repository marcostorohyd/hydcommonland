@component('mail::message')
# Confirma el borrado de su cuenta

Una vez eliminada su cuenta de usuario/a no podrá acceder al servicio. Sus datos y documentos será borrados de forma permanente.

¿Estás seguro de querer borrar su cuenta?

@component('mail::button', ['url' => $url])
Sí, deseo borrar mi cuenta
@endcomponent

{{ config('app.name') }}
@endcomponent
