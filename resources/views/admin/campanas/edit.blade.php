<x-layouts.app header="Editar: {{ $campana->titulo }}">
    <div class="card" style="max-width:700px">
        <div class="card-header">Editar Campaña</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.campanas.update', $campana) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Título *</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $campana->titulo) }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tipo *</label>
                        <select name="tipo_campana_id" class="form-control" required>
                            @foreach($tipos as $t)
                                <option value="{{ $t->id }}" {{ $campana->tipo_campana_id==$t->id?'selected':'' }}>{{ $t->icono }} {{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" class="form-control" required>
                            @foreach(['BORRADOR','PUBLICADA','EN_CURSO','FINALIZADA','CANCELADA'] as $e)
                                <option value="{{ $e }}" {{ $campana->estado===$e?'selected':'' }}>{{ $e }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha *</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $campana->fecha->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Hora</label>
                        <input type="time" name="hora" class="form-control" value="{{ old('hora', $campana->hora) }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Lugar</label>
                        <input type="text" name="lugar" class="form-control" value="{{ old('lugar', $campana->lugar) }}">
                    </div>
                    <div class="form-group">
                        <label>Capacidad</label>
                        <input type="number" name="capacidad" class="form-control" value="{{ old('capacidad', $campana->capacidad) }}" min="1">
                    </div>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control">{{ old('descripcion', $campana->descripcion) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Requisitos</label>
                    <textarea name="requisitos" class="form-control">{{ old('requisitos', $campana->requisitos) }}</textarea>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1rem">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.campanas.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
