<x-layouts.app header="Nueva Campaña">
    <div class="card" style="max-width:700px">
        <div class="card-header">Datos de la Campaña</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.campanas.store') }}">
                @csrf
                <div class="form-group">
                    <label>Título *</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
                    @error('titulo') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tipo de Campaña *</label>
                        <select name="tipo_campana_id" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($tipos as $t)
                                <option value="{{ $t->id }}" {{ old('tipo_campana_id')==$t->id?'selected':'' }}>{{ $t->icono }} {{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" class="form-control" required>
                            <option value="BORRADOR">Borrador</option>
                            <option value="PUBLICADA">Publicada</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha *</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Hora</label>
                        <input type="time" name="hora" class="form-control" value="{{ old('hora') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Lugar</label>
                        <input type="text" name="lugar" class="form-control" value="{{ old('lugar') }}">
                    </div>
                    <div class="form-group">
                        <label>Capacidad</label>
                        <input type="number" name="capacidad" class="form-control" value="{{ old('capacidad') }}" min="1">
                    </div>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Requisitos</label>
                    <textarea name="requisitos" class="form-control">{{ old('requisitos') }}</textarea>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1rem">
                    <button type="submit" class="btn btn-primary">Crear Campaña</button>
                    <a href="{{ route('admin.campanas.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
