
{{-- Usage in blade file --}}

{{-- 
@include('components.form.input', [
    'label' => 'Email',
    'name' => 'email',
    'type' => 'email',
    'colClass' => 'col-12',
    'placeholder' => 'Enter your email',
    'model' => $user ?? null,
    'autofocus' => true,
]) 
--}}

<div class="{{ $colClass ?? 'col-md-6' }}">
    {{-- Label for the input --}}
    <label for="{{ $name }}" class="form-label">{{ $label ?? ucfirst($name) }}</label>

    {{-- Input Field --}}
    <input type="{{ $type ?? 'text' }}" class="form-control" name="{{ $name }}"
        id="{{ $name }}" {{-- Optional Attributes --}}
        @if (!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
        @if (!empty($autofocus)) autofocus @endif @if (!empty($disabled)) disabled @endif
        @if (!empty($readonly)) readonly @endif {{-- Value: from old input or model --}}
        @if (isset($model) && isset($model->$name)) value="{{ old($name, $model->$name) }}"
        @else
            value="{{ old($name) }}" @endif
        {{-- Aria for screen readers on error --}} @if ($errors->has($name)) aria-describedby="{{ $name }}-feedback" @endif>

</div>

