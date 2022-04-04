<input type="hidden" name="id" value="{{ $supplier->id }}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">
                Nome Fantasia <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'name'])"
                   id="name"
                   name="name"
                   value="{{ old('name', $supplier->name) }}"
                   autofocus=""
            >
            @invalidFeedback(['key' => 'name'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="company">
                Razão Social <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'company'])"
                   id="company"
                   name="company"
                   value="{{ old('company', $supplier->company) }}"
            >
            @invalidFeedback(['key' => 'company'])
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email">
                E-mail <span class="text-danger">*</span>
            </label>
            <input type="email"
                   class="form-control @isInvalid(['key' => 'email'])"
                   id="email"
                   name="email"
                   value="{{ old('email', $supplier->email) }}"
            >
            @invalidFeedback(['key' => 'email'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="cnpj">
                CNPJ <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'cnpj'])"
                   id="cnpj"
                   name="cnpj"
                   value="{{ old('cnpj', $supplier->cnpj) }}"
                   data-input-mask="cnpj"
            >
            @invalidFeedback(['key' => 'cnpj'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="phone">
                Telefone <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'phone'])"
                   id="phone"
                   name="phone"
                   value="{{ old('phone', $supplier->phone) }}"
                   data-input-mask="phone"
            >
            @invalidFeedback(['key' => 'phone'])
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="cep">
                CEP <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control js-cep-autocomplete @isInvalid(['key' => 'cep'])"
                   id="cep"
                   name="cep"
                   value="{{ old('cep', $supplier->cep) }}"
                   data-input-mask="cep"
            >
            @invalidFeedback(['key' => 'cep'])
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="address">
                Endereço <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'address'])"
                   id="address"
                   name="address"
                   value="{{ old('address', $supplier->address) }}"
                   data-cep="logradouro"
            >
            @invalidFeedback(['key' => 'address'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="number">
                Número <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'number'])"
                   id="number"
                   name="number"
                   value="{{ old('number', $supplier->number) }}"
            >
            @invalidFeedback(['key' => 'number'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="neighborhood">
                Bairro <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'neighborhood'])"
                   id="neighborhood"
                   name="neighborhood"
                   value="{{ old('neighborhood', $supplier->neighborhood) }}"
                   data-cep="bairro"
            >
            @invalidFeedback(['key' => 'neighborhood'])
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="city">
                Cidade <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'city'])"
                   id="city"
                   name="city"
                   value="{{ old('city', $supplier->city) }}"
                   data-cep="localidade"
            >
            @invalidFeedback(['key' => 'city'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="uf">
                Estado <span class="text-danger">*</span>
            </label>
            <select class="form-control @isInvalid(['key' => 'uf'])"
                    id="uf"
                    name="uf"
                    data-cep="uf"
            >
                @selectOption(['items' => $states, 'selected' => old('uf', $supplier->uf)])
            </select>
            @invalidFeedback(['key' => 'uf'])
        </div>
    </div>

</div>