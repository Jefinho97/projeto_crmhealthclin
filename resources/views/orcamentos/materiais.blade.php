<div class="form-group">
            <label for="title">Materiais e Medicamentos:</label>
            <select name="materials[]" id="materials" class="form-control">
                @foreach($materials as $material)
                <option value="{{ $material->id }}">{{ $material->nome }}</option>
                @endforeach
            </select>
            <label for="title">Quantidade:</label>
            <input type="int" class="form-control" name="quantMat[]" id="quantEquipe">
            <button type="button" id="add-material"> + </button>
</div>