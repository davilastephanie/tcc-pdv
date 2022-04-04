<input type="hidden" name="id" value="{{ $subcategory->id }}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">
                Nome <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'name'])"
                   id="name"
                   name="name"
                   value="{{ old('name', $subcategory->name) }}"
                   autofocus=""
            >
            @invalidFeedback(['key' => 'name'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="category_id">
                Categoria <span class="text-danger">*</span>
            </label>
            <select class="form-control @isInvalid(['key' => 'category_id'])"
                    id="category_id"
                    name="category_id"
            >
                @selectOption(['items' => $categories, 'selected' => old('category_id', $subcategory->category_id)])
            </select>
            @invalidFeedback(['key' => 'category_id'])
        </div>
    </div>
</div>