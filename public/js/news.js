/**
 * Remove the specified resource from storage.
 *
 * @param {int} id
 */
function newsDestroy(id) {
  var id = id-0 || 0;
  if (! id) {
    return;
  }

  if (! confirm('Se va a borrar de forma definitiva la noticia seleccionado. ¿Continuar?')) {
    return;
  }

  $.ajax({
    method: 'DELETE',
    url: '/backend/news/' + id
  }).done(function(res) {
    NotifyTable('#error-wrapper', 'success', 'Noticia borrada correctamente.');
    $('#datatable-filter').DataTable().ajax.reload();
  }).fail(function (res) {
    if (405 == res.status) {
      NotifyTable('#error-wrapper', 'danger', 'No tienes permiso para borrar la noticia.');
    } else if (422 == res.status) {
      NotifyTable('#error-wrapper', 'danger', res.responseJSON.error);
    } else {
      NotifyTable('#error-wrapper', 'danger', 'Debido a un error no se ha podido eliminar la noticia.');
    }
  });
}
