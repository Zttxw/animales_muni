<x-layouts.app header="Registrar Vacuna — {{ $animal->nombre }}">
    <div style="margin-bottom:1rem">
        <a href="{{ route('ciudadano.animales.show', $animal) }}" class="btn btn-outline btn-sm">← Volver</a>
    </div>

    <div class="card" style="max-width:600px">
        <div class="card-header">Nueva Vacunación</div>
        <div class="card-body">
            <form method="POST" action="{{ route('ciudadano.animales.vacunaciones.store', $animal) }}">
                @csrf
                <div class="form-group">
                    <label>Vacuna del Catálogo</label>
                    <select id="vacuna_id" name="vacuna_id" class="form-control" onchange="document.getElementById('nombre_vacuna').value = this.options[this.selectedIndex].text">
                        <option value="">— Seleccionar o escribir manualmente —</option>
                        @foreach($catalogo as $v)
                            <option value="{{ $v->id }}">{{ $v->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nombre de la Vacuna *</label>
                    <input type="text" id="nombre_vacuna" name="nombre_vacuna" class="form-control" value="{{ old('nombre_vacuna') }}" required>
                    @error('nombre_vacuna') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha de Aplicación *</label>
                        <input type="date" name="fecha_aplicacion" class="form-control" value="{{ old('fecha_aplicacion', date('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Próxima Fecha</label>
                        <input type="date" name="proxima_fecha" class="form-control" value="{{ old('proxima_fecha') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1rem">
                    <button type="submit" class="btn btn-success">Registrar Vacuna</button>
                    <a href="{{ route('ciudadano.animales.show', $animal) }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
