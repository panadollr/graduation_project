<!-- Màn hình loading -->
<div id="loading" style="display: none;">
    <div class="loader"></div>
</div>

<style>
    #loading {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        border: 8px solid #f3f3f3; /* Light grey */
        border-top: 8px solid #1f3bb3; /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    // Hiển thị màn hình loading khi có sự kiện 'beforeunload'
    window.addEventListener('beforeunload', function() {
        document.getElementById('loading').style.display = 'flex';
    });

    function loading(){
        document.getElementById('loading').style.display = 'flex';
    }
</script>
