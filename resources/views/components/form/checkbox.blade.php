{{-- 
@include('components.form.checkbox', [
    'name' => 'terms',
    'label' => 'I agree to the terms and conditions',
    'model' => $user ?? null,
    'required' => true,
]) 
--}}
@php
    $options = $options ?? [];
@endphp


@php
    $selectedValues = old($name)
        ?? ($model->$name ?? null)
        ?? ($value ?? []);

    if (!is_array($selectedValues)) {
        $selectedValues = json_decode($selectedValues, true) ?? [];
    }

    $chunks = array_chunk($options, 5, true); // 5 per column
@endphp

<div class="{{ $colClass ?? '' }}">
    <label class="form-label d-block mb-2">{{ $label ?? ucfirst($name) }}</label>

    <div class="row">
        @foreach($chunks as $chunk)
            <div class="col">
                @foreach($chunk as $key => $option)
                    @php $checkboxId = $name . '_' . $key; @endphp

                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="{{ $name }}[]"
                            id="{{ $checkboxId }}"
                            class="form-check-input @error($name) is-invalid @enderror"
                            value="{{ $key }}"
                            {{ in_array((string)$key, array_map('strval', $selectedValues)) ? 'checked' : '' }}
                        >

                        <label class="form-check-label" for="{{ $checkboxId }}">
                            {{ $option }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

