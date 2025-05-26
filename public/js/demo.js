/**
 * Remove the specified resource from storage.
 *
 * @param {int} id
 */
function demoDestroy(id) {
  var id = id-0 || 0;
  if (! id) {
    return;
  }

  if (! confirm('Se va a borrar de forma definitiva el caso demostrativo seleccionado. ¿Continuar?')) {
    return;
  }

  $.ajax({
    method: 'DELETE',
    url: '/backend/demo/' + id
  }).done(function(res) {
    NotifyTable('#error-wrapper', 'success', 'Caso demostrativo borrada correctamente.');
    $('#datatable-filter').DataTable().ajax.reload();
  }).fail(function (res) {
    if (405 == res.status) {
      NotifyTable('#error-wrapper', 'danger', 'No tienes permiso para borrar el caso demostrativo.');
    } else if (422 == res.status) {
      NotifyTable('#error-wrapper', 'danger', res.responseJSON.error);
    } else {
      NotifyTable('#error-wrapper', 'danger', 'Debido a un error no se ha podido eliminar el caso demostrativo.');
    }
  });
}
