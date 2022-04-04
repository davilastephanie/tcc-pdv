<div class="form-upload">
    <input type="hidden" name="{{ $key }}" value="{{ $value }}">

    <div class="input-upload-empty {{ !empty($value) ? 'display-none' : '' }}">
        <div class="btn btn-dark btn-icon">
            <input type="file"
                   id="upload-image-{{ $key }}"
                   data-url="{{ url('/api/upload') }}"
                   data-key="{{ $key }}"
            >
            <i class="c-icon cil-arrow-thick-to-top"></i> Selecionar imagem...
        </div>
    </div>
    <div class="input-upload-preview {{ empty($value) ? 'display-none' : '' }}">
        <button type="button"
                class="btn btn-info btn-icon"
                data-fancybox=""
                data-src="{{ !empty($value) ? url($value) : '' }}"
                data-type="image"
        >
            <i class="c-icon cil-zoom-in"></i> Visualizar imagem
        </button>
        <button type="button" class="btn btn-outline-danger btn-icon js-upload-image-remove">
            <i class="c-icon cil-trash"></i> Remover
        </button>
    </div>

    @invalidFeedback(['key' => $key])
</div>