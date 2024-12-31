<div x-data="{ logo: @entangle($attributes->wire('model')).defer }" class="flex items-center">
    <input type="text" x-bind:value="logo ? logo.name : '{{ $logo }}'" readonly class="form-input" placeholder="Chưa chọn file..." />
    
    <label for="file-input" class="custom-file-upload">
        {{ $title }}
    </label>
    
    <input 
        id="file-input" 
        type="file" 
        {{ $attributes }} 
        @change="logo = $event.target.files[0]" 
        class="hidden"
    >
    
    <div x-show="logo || '{{ $logo }}'" class="mt-2">
        <center>
            <img 
                x-show="logo" 
                x-bind:src="URL.createObjectURL(logo)" 
                alt="Preview" 
                class="mt-2" 
                style="width: 200px; height: 200px; object-fit: cover; border-radius: 5px;"
            >
            <img 
                x-show="!logo && '{{ $logo }}'" 
                src="{{ Storage::url($logo) }}" 
                alt="Current Logo" 
                class="mt-2" 
                style="width: 200px; height: 200px; object-fit: cover; border-radius: 5px;"
            >
        </center>
    </div>
</div>

<style>
    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 0 5px 5px 0;
        background-color: #3498db;
        color: white;
        font-weight: bold;
        transition: background-color 0.3s;
        border: 1px solid #3498db;
    }

    .custom-file-upload:hover {
        background-color: #2980b9;
    }

    .form-input {
        padding: 10px;
        width: 70%; /* Adjust width as necessary */
        border: 1px solid #3498db;
        border-radius: 5px 0 0 5px; /* Rounded corners */
        outline: none; /* Remove outline */
    }

    input[type="file"] {
        display: none; /* Hide file input */
    }
</style>
