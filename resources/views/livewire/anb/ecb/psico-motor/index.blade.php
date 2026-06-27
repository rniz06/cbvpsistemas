<div>

<div class="card card-primary">

<div class="card-header">

<h3 class="card-title">

Motor de Corrección

<br>

<small>

{{ $test->nombre }}

</small>

</h3>

</div>

<div class="card-body p-0">

<div class="table-responsive">

<table
class="table table-bordered table-hover mb-0"
>

<thead>

<tr class="text-center">

<th width="60">

#

</th>

<th>

Pregunta

</th>

@foreach($dimensiones as $dimension)

<th>

{{ $dimension->nombre }}

</th>

@endforeach

</tr>

</thead>

<tbody>

@foreach($preguntas as $pregunta)

<tr>

<td class="text-center">

{{ $pregunta->orden }}

</td>

<td>

{{ $pregunta->pregunta }}

</td>

@foreach($dimensiones as $dimension)

<td class="text-center">

<input
    type="checkbox"

    @checked(
        isset(
            $relaciones[$pregunta->id][$dimension->id]
        )
    )

    wire:click="toggleRelacion(
        {{ $pregunta->id }},
        {{ $dimension->id }}
    )"
>

</td>

@endforeach

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>