<x-layouts.app header="Registrar Animal">
    <div class="card" style="max-width:700px">
        <div class="card-header">Datos del Animal</div>
        <div class="card-body">
            <form method="POST" action="{{ route('ciudadano.animales.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    @error('nombre') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="especie_id">Especie *</label>
                        <select id="especie_id" name="especie_id" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($especies as $esp)
                                <option value="{{ $esp->id }}" {{ old('especie_id') == $esp->id ? 'selected' : '' }}>{{ $esp->nombre }}</option>
                            @endforeach
                        </select>
                        @error('especie_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label for="raza_id">Raza</label>
                        <select id="raza_id" name="raza_id" class="form-control">
                            <option value="">Seleccionar especie primero...</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sexo">Sexo *</label>
                        <select id="sexo" name="sexo" class="form-control" required>
                            <option value="DESCONOCIDO" {{ old('sexo') === 'DESCONOCIDO' ? 'selected' : '' }}>Desconocido</option>
                            <option value="M" {{ old('sexo') === 'M' ? 'selected' : '' }}>Macho</option>
                            <option value="H" {{ old('sexo') === 'H' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" id="color" name="color" class="form-control" value="{{ old('color') }}">
                    </div>
                    <div class="form-group">
                        <label for="tamano">Tamaño</label>
                        <select id="tamano" name="tamano" class="form-control">
                            <option value="">Seleccionar...</option>
                            <option value="PEQUEÑO">Pequeño</option>
                            <option value="MEDIANO">Mediano</option>
                            <option value="GRANDE">Grande</option>
                            <option value="GIGANTE">Gigante</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="estado_reproductivo">Estado Reproductivo</label>
                    <select id="estado_reproductivo" name="estado_reproductivo" class="form-control">
                        <option value="DESCONOCIDO">Desconocido</option>
                        <option value="ENTERO">Entero</option>
                        <option value="ESTERILIZADO">Esterilizado</option>
                        <option value="CASTRADO">Castrado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="senas_particulares">Señas Particulares</label>
                    <textarea id="senas_particulares" name="senas_particulares" class="form-control">{{ old('senas_particulares') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="foto">Foto del Animal</label>
                    <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                </div>

                <div style="display:flex;gap:.75rem;margin-top:1.5rem">
                    <button type="submit" class="btn btn-primary">Registrar Animal</button>
                    <a href="{{ route('ciudadano.animales.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('especie_id').addEventListener('change', function() {
            const razaSelect = document.getElementById('raza_id');
            razaSelect.innerHTML = '<option value="">Cargando...</option>';

            if (!this.value) {
                razaSelect.innerHTML = '<option value="">Seleccionar especie primero...</option>';
                return;
            }

            fetch(`/api/especies/${this.value}/razas`)
                .then(r => r.json())
                .then(razas => {
                    razaSelect.innerHTML = '<option value="">Seleccionar...</option>';
                    razas.forEach(r => {
                        razaSelect.innerHTML += `<option value="${r.id}">${r.nombre}</option>`;
                    });
                });
        });
    </script>
    @endpush
</x-layouts.app>
