{{-- 
@include('components.form.date', [
    'name' => 'dob',
    'label' => 'Date of Birth',
    'model' => $user ?? null,
    'autofocus' => true,
    'placeholder' => 'YYYY-MM-DD',
    'colClass' => 'col-12',
])
--}}


{{-- 
<div class="{{ $colClass ?? 'col-md-6' }}">
    <label for="{{ $name }}" class="form-label">{{ $label ?? ucfirst($name) }}</label>
    <input type="date" id="{{ $name }}" name="{{ $name }}"
        class="{{ $class ?? '' }} @error($name) is-invalid @enderror" placeholder="{{ $placeholder ?? 'YYYY-MM-DD' }}"
        @if (!empty($autofocus)) autofocus @endif @if (!empty($disabled)) disabled @endif
        value="{{ old($name) ?? (isset($model) && isset($model->$name) ? \Carbon\Carbon::parse($model->$name)->format('Y-m-d') : '') }}">

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror

</div> 
--}}


{{-- New --}}

{{-- Usage --}}
{{-- 
@include('components.form.date', [
    'label' => 'Date of Birth',
    'name' => 'dob',
    'colClass' => 'col-md-6',
    'model' => $user ?? null,
    'min' => '1900-01-01',
    'max' => date('Y-m-d'),
]) 
--}}



<div class="{{ $colClass ?? '' }}">
    {{-- Label for the date input --}}
    <label for="{{ $name }}" class="form-label">{{ $label ?? ucfirst($name) }}</label>

    {{-- Date Input Field --}}
    <input 
        type="date" 
        class="form-control @error($name) is-invalid @enderror" 
        name="{{ $name }}"
        id="{{ $name }}"
        {{-- Optional Attributes --}}
        @if (!empty($autofocus)) autofocus @endif
        @if (!empty($disabled)) disabled @endif
        @if (!empty($readonly)) readonly @endif
        @if (!empty($min)) min="{{ $min }}" @endif
        @if (!empty($max)) max="{{ $max }}" @endif

        {{-- Value: from old input or model --}}
        @if (isset($model) && isset($model->$name)) 
            value="{{ old($name, \Carbon\Carbon::parse($model->$name)->format('Y-m-d')) }}"
        @else
            value="{{ old($name) }}"
        @endif

        {{-- Aria for screen readers on error --}}
        @if ($errors->has($name)) aria-describedby="{{ $name }}-feedback" @endif
    >

    {{-- Error message --}}
    @error($name)
        <div id="{{ $name }}-feedback" class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
