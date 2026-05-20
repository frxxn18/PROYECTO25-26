<div class="mb-3">
    <label class="form-label">Título <span class="text-danger">*</span></label>
    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
           value="{{ old('titulo', $libro->titulo ?? '') }}">
    @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Autor <span class="text-danger">*</span></label>
    <input type="text" name="autor" class="form-control @error('autor') is-invalid @enderror"
           value="{{ old('autor', $libro->autor ?? '') }}">
    @error('autor') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">ISBN</label>
    <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
           value="{{ old('isbn', $libro->isbn ?? '') }}" placeholder="Opcional">
    @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Materia</label>
    <select name="materia_id" class="form-select @error('materia_id') is-invalid @enderror">
        <option value="">Sin materia asignada</option>
        @foreach($materias as $materia)
            <option value="{{ $materia->id }}"
                {{ old('materia_id', $libro->materia_id ?? '') == $materia->id ? 'selected' : '' }}>
                {{ $materia->nombre }}
            </option>
        @endforeach
    </select>
    @error('materia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nº de ejemplares <span class="text-danger">*</span></label>
    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
           value="{{ old('stock', $libro->stock ?? 1) }}" min="1">
    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>