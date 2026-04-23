<x-layouts.app header="Editar: {{ $animal->nombre }}">
    <div class="card" style="max-width:700px">
        <div class="card-header">Editar Animal</div>
        <div class="card-body">
            <form method="POST" action="{{ route('ciudadano.animales.update', $animal) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $animal->nombre) }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Especie *</label>
                        <select id="especie_id" name="especie_id" class="form-control" required>
                            @foreach($especies as $esp)
                                <option value="{{ $esp->id }}" {{ $animal->especie_id==$esp->id?'selected':'' }}>{{ $esp->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Raza</label>
                        <select id="raza_id" name="raza_id" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($razas as $r)
                                <option value="{{ $r->id }}" {{ $animal->raza_id==$r->id?'selected':'' }}>{{ $r->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Sexo *</label>
                        <select name="sexo" class="form-control" required>
                            <option value="M" {{ $animal->sexo==='M'?'selected':'' }}>Macho</option>
                            <option value="H" {{ $animal->sexo==='H'?'selected':'' }}>Hembra</option>
                            <option value="DESCONOCIDO" {{ $animal->sexo==='DESCONOCIDO'?'selected':'' }}>Desconocido</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $animal->fecha_nacimiento?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Color</label>
                        <input type="text" name="color" class="form-control" value="{{ old('color', $animal->color) }}">
                    </div>
                    <div class="form-group">
                        <label>Tamaño</label>
                        <select name="tamano" class="form-control">
                            <option value="">—</option>
                            @foreach(['PEQUEÑO','MEDIANO','GRANDE','GIGANTE'] as $t)
                                <option value="{{ $t }}" {{ $animal->tamano===$t?'selected':'' }}>{{ ucfirst(strtolower($t)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Estado Reproductivo</label>
                    <select name="estado_reproductivo" class="form-control">
                        @foreach(['DESCONOCIDO','ENTERO','ESTERILIZADO','CASTRADO'] as $er)
                            <option value="{{ $er }}" {{ $animal->estado_reproductivo===$er?'selected':'' }}>{{ ucfirst(strtolower($er)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Señas Particulares</label>
                    <textarea name="senas_particulares" class="form-control">{{ old('senas_particulares', $animal->senas_particulares) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control">{{ old('observaciones', $animal->observaciones) }}</textarea>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1rem">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="{{ route('ciudadano.animales.show', $animal) }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('especie_id').addEventListener('change', function() {
            const razaSelect = document.getElementById('raza_id');
            razaSelect.innerHTML = '<option value="">Cargando...</option>';
            fetch(`/api/especies/${this.value}/razas`)
                .then(r => r.json())
                .then(razas => {
                    razaSelect.innerHTML = '<option value="">Seleccionar...</option>';
                    razas.forEach(r => razaSelect.innerHTML += `<option value="${r.id}">${r.nombre}</option>`);
                });
        });
    </script>
    @endpush
</x-layouts.app>
