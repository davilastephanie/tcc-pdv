<input type="hidden" name="id" value="{{ $client->id }}">

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
                   value="{{ old('name', $client->name) }}"
                   autofocus=""
            >
            @invalidFeedback(['key' => 'name'])
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
                   value="{{ old('email', $client->email) }}"
            >
            @invalidFeedback(['key' => 'email'])
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="cpf">
                CPF <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'cpf'])"
                   id="cpf"
                   name="cpf"
                   value="{{ old('cpf', $client->cpf) }}"
                   data-input-mask="cpf"
            >
            @invalidFeedback(['key' => 'cpf'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="rg">
                RG <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'rg'])"
                   id="rg"
                   name="rg"
                   value="{{ old('rg', $client->rg) }}"
                   maxlength="10"
            >
            @invalidFeedback(['key' => 'rg'])
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
                   value="{{ old('phone', $client->phone) }}"
                   data-input-mask="phone"
            >
            @invalidFeedback(['key' => 'phone'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="birthday">
                Data de Nascimento <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control js-datepicker @isInvalid(['key' => 'birthday'])"
                   id="birthday"
                   name="birthday"
                   value="{{ old('birthday', $client->birthday) }}"
                   data-input-mask="date"
            >
            @invalidFeedback(['key' => 'birthday'])
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
                   value="{{ old('cep', $client->cep) }}"
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
                   value="{{ old('address', $client->address) }}"
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
                   value="{{ old('number', $client->number) }}"
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
                   value="{{ old('neighborhood', $client->neighborhood) }}"
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
                   value="{{ old('city', $client->city) }}"
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
                @selectOption(['items' => $states, 'selected' => old('uf', $client->uf)])
            </select>
            @invalidFeedback(['key' => 'uf'])
        </div>
    </div>

</div>