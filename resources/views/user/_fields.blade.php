<input type="hidden" name="id" value="{{ $user->id }}">

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
                   value="{{ old('name', $user->name) }}"
                   autofocus=""
            >
            @invalidFeedback(['key' => 'name'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">
                Telefone <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'phone'])"
                   id="phone"
                   name="phone"
                   value="{{ old('phone', $user->phone) }}"
                   data-input-mask="phone"
            >
            @invalidFeedback(['key' => 'phone'])
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
                   value="{{ old('email', $user->email) }}"
            >
            @invalidFeedback(['key' => 'email'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">
                Senha <span class="text-danger {{ !empty($user->id) ? 'd-none' : '' }}">*</span>
            </label>
            <input type="text"
                   class="form-control @isInvalid(['key' => 'password'])"
                   id="password"
                   name="password"
                   value="{{ old('password') }}"
                   placeholder="Deixe em branco para não alterar"
            >
            @invalidFeedback(['key' => 'password'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="role_id">
                Perfil <span class="text-danger">*</span>
            </label>
            <select class="form-control @isInvalid(['key' => 'role_id'])"
                    id="role_id"
                    name="role_id"
            >
                @selectOption(['items' => $roles, 'selected' => old('role_id', $user->role_id)])
            </select>
            @invalidFeedback(['key' => 'role_id'])
        </div>
    </div>
</div>