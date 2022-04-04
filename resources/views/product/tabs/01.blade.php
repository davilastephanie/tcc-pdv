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
                   value="{{ old('name', $product->name) }}"
                   autofocus=""
            >
            @invalidFeedback(['key' => 'name'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="barcode">
                Código de barras <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'barcode'])"
                   id="barcode"
                   name="barcode"
                   value="{{ old('barcode', $product->barcode) }}"
            >
            @invalidFeedback(['key' => 'barcode'])
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
                @selectOption(['items' => $categories, 'selected' => old('category_id', $product->category_id)])
            </select>
            @invalidFeedback(['key' => 'category_id'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="subcategory_id">
                Subcategoria <span class="text-danger">*</span>
            </label>
            @php
                $subcategory_id = old('subcategory_id', $product->subcategory_id);
            @endphp
            <select class="form-control @isInvalid(['key' => 'subcategory_id'])"
                    id="subcategory_id"
                    name="subcategory_id"
                    {{ empty($subcategory_id) ? 'disabled' : '' }}
            >
                @selectOption(['items' => $subcategories, 'selected' => $subcategory_id])
            </select>
            @invalidFeedback(['key' => 'subcategory_id'])
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="supplier_id">
                Fornecedor <span class="text-danger">*</span>
            </label>
            <select class="form-control @isInvalid(['key' => 'supplier_id'])"
                    id="supplier_id"
                    name="supplier_id"
            >
                @selectOption(['items' => $suppliers, 'selected' => old('supplier_id', $product->supplier_id)])
            </select>
            @invalidFeedback(['key' => 'supplier_id'])
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="description">
                Descrição <span class="text-danger">*</span>
            </label>
            <textarea class="form-control @isInvalid(['key' => 'description'])"
                      id="description"
                      name="description"
                      rows="6"
            >{{ old('description', $product->description) }}</textarea>
            @invalidFeedback(['key' => 'description'])
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="price">
                Preço <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">R$</div>
                </div>
                <input type="text"
                       class="form-control @isInvalid(['key' => 'price'])"
                       id="price"
                       name="price"
                       value="{{ old('price', $product->price_show) }}"
                       data-input-mask="money"
                       maxlength="9"
                >
            </div>
            @invalidFeedback(['key' => 'price'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="image">
                Imagem <span class="text-danger">*</span>
            </label>
            @uploadImage(['key' => 'image', 'value' => old('image', $product->image)])
        </div>
    </div>

    @if (!$product->id)
        <div class="col-md-3">
            <div class="form-group">
                <label for="stock">
                    Estoque inicial <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="c-icon cil-layers"></i></div>
                    </div>
                    <input type="text"
                           class="form-control @isInvalid(['key' => 'stock'])"
                           id="stock"
                           name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           data-input-mask="numeric"
                           maxlength="6"
                    >
                </div>
                @invalidFeedback(['key' => 'stock'])
            </div>
        </div>
    @endif
</div>

@push('script')
    <script>
      var apiUrl = '{{ url('/api/subcategories') }}';

      $(function() {
        var $subcategory = $('#subcategory_id');

        $('#category_id').on('change', function() {
          $subcategory.val(null);
          $subcategory.prop('disabled', true);
          $subcategory.html('<option></option>');

          $.blockUI();
          $.get(apiUrl, {category_id: $(this).val()}, function(response) {
            $.unblockUI();

            if (response.length > 0) {
              $.each(response, function(i, item) {
                $subcategory.append(new Option(item.name, item.id));
              });

              $subcategory.prop('disabled', false);
            }
          });
        });
      });
    </script>
@endpush