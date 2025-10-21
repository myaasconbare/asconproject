<div x-data="redeem">
    <form wire:submit='submit' action="">
        <button type="submit" class="i-btn btn--lg btn--primary spin-btn">
            <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
            Redeem License
        </button>
    </form>
</div>

@script
    <script>
        Alpine.data('redeem', () => ({
            init(){
                $successMsg = "{{ session('success') }}";
                $errorMsg = "{{ session('error') }}";

                $successMsg && notifySuccess($successMsg);
                $errorMsg && notifyError($errorMsg);

                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
    </script>
@endscript
