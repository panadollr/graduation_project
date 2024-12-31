<div 
    x-data="{ show: @entangle($attributes->wire('model')) }" 
    x-show="show" 
    class="modal2">

    <div class="modal-container" x-show="show" x-transition:enter.duration.400ms
    x-transition:leave.duration.300ms>
    <div class="modal-content">
        <h4 class="card-title" style="text-align: center;padding: 10px 0;">{{ $title }}</h4>
        <div style="margin-top: -40px">{{ $slot }}</div>
    </div>
    <div class="modal-footer">{{ $footer }}</div>
</div>
</div>

<!-- CSS -->
<style>
    .modal2 {
        position: fixed;
        z-index: 100;
        top: 54%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%;
        height: auto;
        min-width: 600px;
    }

    .modal-container {
        background-color: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.8);
        border-radius: 10px
    }
    
    .modal-content {
        position: relative;
        margin: auto;
        padding: 5px;
        border-radius: 8px;
        width: 100%;
        max-height: 500px;
        overflow-y: auto;
        z-index: 100;
    }

    .modal-footer {
        padding: 10px 15px; 
        border-top: 1px solid #e0e0e0; 
    }
</style>
