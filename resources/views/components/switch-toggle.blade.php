<style>
    .switch-container {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
        left: 10px;
    }

    .switch-input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: background-color 0.3s ease;
        border-radius: 30px;
    }

    .switch-label::before {
        content: "";
        position: absolute;
        height: 20px;
        width: 20px;
        background-color: #1F3BB3;
        transition: transform 0.3s ease;
        border-radius: 50%;
    }

    .switch-input:checked + .switch-label {
        background-color: #8597e7;
    }

    .switch-input:checked + .switch-label::before {
        transform: translateX(30px);
    }
</style>

<div class="switch-container">
    <input 
        type="checkbox" 
        id="{{ $id }}" 
        class="switch-input" 
        {{ $checked ? 'checked' : '' }} 
        x-on:click="{{ $callback }}">
    <label class="switch-label" for="{{ $id }}"></label>
</div>
