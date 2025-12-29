{{-- Usage in blade file --}}

{{-- 
@include('components.form.button', [
    'type' => 'submit',
    'value' => 'Sign In',
    'class' => 'btn-secondary',
    'colClass' => 'col-12',
])
--}}


<div class="{{ $colClass ?? 'col-md-6' }}">
    {{-- Reusable Button Component --}}
    <button type="{{ $type ?? 'submit' }}" class="btn {{ $class ?? 'btn-primary' }}">
        {{ $value ?? 'Submit' }}
    </button>
</div>

