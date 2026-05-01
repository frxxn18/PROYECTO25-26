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
    <label class="form-label">Nº de ejemplares <span class="text-danger">*</span></label>
    <input type="number" name="ejemplares" class="form-control @error('ejemplares') is-invalid @enderror"
           value="{{ old('ejemplares', $libro->ejemplares ?? 1) }}" min="1">
    @error('ejemplares') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>