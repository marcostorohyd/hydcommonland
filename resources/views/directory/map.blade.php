@if (! $locations->count())
    <p class="text-danger">{{ __('No se han encontrado resultados') }}</p>
@endif

<div id="map"></div>
<div id="marker-tooltip"></div>

@if (! empty($flag))
    <script>
        MapInitLocations('map', { lag: 50.85, lng: 4.35 }, @json($locations), function (res, point) {
            var html = new Array();
            $.each(res.data, function (index, elem) {
                html.push('<a href="/directory/' + elem.id + '"><strong>' + elem.name + '</strong><br>' + elem.entity.name + '</a>');
            });

            offset = 50;
            if (point.x + 200 > $('#map').width()) {
                offset -= 212;
            }

            $('#marker-tooltip').html(html.join('<hr>')).css({
                'left': point.x + offset,
                'top': point.y + 10
            }).show();
        });
    </script>
@endif
