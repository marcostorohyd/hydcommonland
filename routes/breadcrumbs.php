<?php

// Home

use App\DirectoryChange;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('Inicio'), route('home'));
});

// Backend

// Dashboard
Breadcrumbs::for('backend.dashboard', function ($trail) {
    $trail->push(__('Inicio'), route('backend.dashboard'));
});

// Account
Breadcrumbs::for('backend.account.show', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Perfil'), route('backend.account.show'));
});

Breadcrumbs::for('backend.account.edit_directory', function ($trail) {
    $trail->parent('backend.account.show');
    $trail->push(__('Solicitud cambio de datos'));
});

// Directory
Breadcrumbs::for('backend.directory.index', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Usuarios/as'), route('backend.directory.index'));
});

Breadcrumbs::for('backend.directory.search', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Usuarios/as'), route('backend.directory.search'));
});

Breadcrumbs::for('backend.directory.create', function ($trail) {
    $trail->parent('backend.directory.index');
    $trail->push(__('Nuevo/a usuario/a'));
});

Breadcrumbs::for('backend.directory.show', function ($trail, $directory) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Perfil')." ({$directory->name})");
});

Breadcrumbs::for('backend.directory.edit', function ($trail, $directory) {
    $trail->parent('backend.directory.index');
    $trail->push(__('Editar usuario/a (:name)', ['name' => $directory->name]));
});

// DirectoryChange
Breadcrumbs::for('backend.directory-change.show', function ($trail, DirectoryChange $directoryChange) {
    $trail->parent('backend.directory.edit', $directoryChange->directory);
    $trail->push(__('Solicitud cambio de datos'));
});

// Event
Breadcrumbs::for('backend.event.index', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Eventos'), route('backend.event.index'));
});

Breadcrumbs::for('backend.event.create', function ($trail) {
    $trail->parent('backend.event.index');
    $trail->push(__('Nuevo evento'));
});

Breadcrumbs::for('backend.event.show', function ($trail, $event) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Evento')." ({$event->name})");
});

Breadcrumbs::for('backend.event.edit', function ($trail, $event) {
    $trail->parent('backend.event.index');
    $trail->push(__('Editar evento')." ({$event->name})");
});

// News
Breadcrumbs::for('backend.news.index', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Noticias'), route('backend.news.index'));
});

Breadcrumbs::for('backend.news.create', function ($trail) {
    $trail->parent('backend.news.index');
    $trail->push(__('Nueva noticia'));
});

Breadcrumbs::for('backend.news.show', function ($trail, $news) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Noticia')." ({$news->name})");
});

Breadcrumbs::for('backend.news.edit', function ($trail, $news) {
    $trail->parent('backend.news.index');
    $trail->push(__('Editar noticia')." ({$news->name})");
});

// Demo case study
Breadcrumbs::for('backend.demo.index', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Casos demostrativos'), route('backend.demo.index'));
});

Breadcrumbs::for('backend.demo.create', function ($trail) {
    $trail->parent('backend.demo.index');
    $trail->push(__('Nuevo caso demostrativo'));
});

Breadcrumbs::for('backend.demo.show', function ($trail, $demo) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Caso demostrativo')." ({$demo->name})");
});

Breadcrumbs::for('backend.demo.edit', function ($trail, $demo) {
    $trail->parent('backend.demo.index');
    $trail->push(__('Editar caso demostrativo')." ({$demo->name})");
});

// Media library
Breadcrumbs::for('backend.media.index', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Mediateca'), route('backend.media.index'));
});

Breadcrumbs::for('backend.media.create', function ($trail) {
    $trail->parent('backend.media.index');
    $trail->push(__('Nuevo archivo multimedia'));
});

Breadcrumbs::for('backend.media.show', function ($trail, $media) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Mediateca')." ({$media->name})");
});

Breadcrumbs::for('backend.media.edit', function ($trail, $media) {
    $trail->parent('backend.media.index');
    $trail->push(__('Editar mediateca')." ({$media->name})");
});

// Country
Breadcrumbs::for('backend.country.index', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Países'), route('backend.country.index'));
});

Breadcrumbs::for('backend.country.search', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Países'), route('backend.country.search'));
});

Breadcrumbs::for('backend.country.create', function ($trail) {
    $trail->parent('backend.country.index');
    $trail->push(__('Nuevo país'));
});

Breadcrumbs::for('backend.country.edit', function ($trail, $country) {
    $trail->parent('backend.country.index');
    $trail->push(__('Editar país')." ({$country->name})");
});

// About
Breadcrumbs::for('backend.about.edit', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Editar acerca de'));
});

// Contact
Breadcrumbs::for('backend.contact.edit', function ($trail) {
    $trail->parent('backend.dashboard');
    $trail->push(__('Editar contacto'));
});
