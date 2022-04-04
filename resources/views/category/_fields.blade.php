<input type="hidden" name="id" value="{{ $category->id }}">

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">
                Nome <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'name'])"
                   id="name"
                   name="name"
                   value="{{ old('name', $category->name) }}"
                   autofocus=""
            >
            @invalidFeedback(['key' => 'name'])
        </div>
    </div>
</div>