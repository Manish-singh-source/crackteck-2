{{-- Usage in blade file --}}

{{--
@include('components.form.select', [
    'label' => 'Status',
    'name' => 'status',
    'options' => ["1" => "Active", "2" => "Inactive"],
    'colClass' => 'col-12',
    'model' => $user ?? null,
    'autofocus' => true,
    'class' => 'custom-class',
    'disabled' => true,
])
--}}

@php
    $selectedValue = old($name) ?? ($model->$name ?? null ?? ($value ?? null));
@endphp

<div class="{{ $colClass ?? 'col-12' }}">
    {{-- Label for the select --}}
    <label for="{{ $name }}" class="form-label">
        {{ $label ?? ucfirst($name) }}
    </label>

    {{-- Select Field --}}
    <select id="{{ $name }}" name="{{ $name }}"
        class="form-select w-100 @error($name) is-invalid @enderror {{ $class ?? '' }}"
        @if ($required ?? false) required @endif @if ($disabled ?? false) disabled @endif
        @if ($readonly ?? false) readonly @endif>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" {{ (string) $key === (string) $selectedValue ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>

    {{-- Error message --}}
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
