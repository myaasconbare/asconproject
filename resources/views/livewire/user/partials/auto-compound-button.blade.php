<div x-data="compound">
    <form wire:submit='submit' action="">
        <button type="submit" class="i-btn btn--lg btn--success spin-btn">
            <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
            Auto Compound
        </button>
    </form>
</div>

@script
    <script>
        Alpine.data('compound', () => ({
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
