/**
 * Remove the specified resource from storage.
 *
 * @param {int} id
 */
function countryDestroy(id) {
  var id = id-0 || 0;
  if (! id) {
    return;
  }

  if (! confirm('Se va a borrar de forma definitiva el país seleccionado. ¿Continuar?')) {
    return;
  }

  $.ajax({
    method: 'DELETE',
    url: '/backend/country/' + id
  }).done(function(res) {
    NotifyTable('#error-wrapper', 'success', 'País borrado correctamente.');
    $('#datatable-filter').DataTable().ajax.reload();
  }).fail(function (res) {
    if (405 == res.status) {
      NotifyTable('#error-wrapper', 'danger', 'No tienes permiso para borrar el país.');
    } else if (422 == res.status) {
      NotifyTable('#error-wrapper', 'danger', res.responseJSON.error);
    } else {
      NotifyTable('#error-wrapper', 'danger', 'Debido a un error no se ha podido eliminar el país.');
    }
  });
}

/**
 * Remove the contact resource from storage.
 *
 * @param {int} id
 */
function countryUnassignContact(id) {
  var id = id-0 || 0;
  if (! id) {
    return;
  }

  if (! confirm('Se va a borrar el contacto del país seleccionado. ¿Continuar?')) {
    return;
  }

  $.ajax({
    method: 'GET',
    url: '/backend/country/' + id + '/unassign-contact'
  }).done(function(res) {
    NotifyTable('#error-wrapper', 'success', 'Contacto borrado correctamente.');
    $('#datatable-filter').DataTable().ajax.reload();
  }).fail(function (res) {
    if (405 == res.status) {
      NotifyTable('#error-wrapper', 'danger', 'No tienes permiso para borrar el contacto.');
    } else if (422 == res.status) {
      NotifyTable('#error-wrapper', 'danger', res.responseJSON.error);
    } else {
      NotifyTable('#error-wrapper', 'danger', 'Debido a un error no se ha podido eliminar el contacto.');
    }
  });
}
