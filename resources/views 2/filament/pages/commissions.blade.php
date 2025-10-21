<x-filament-panels::page x-data="commissions">
    <x-filament::tabs label="Content tabs">
        <x-filament::tabs.item :active="$activeTab === 'batches'" :href="$this->query('batches')" tag="a">
            <div class="flex gap-2 items-center justify-center">
                <x-filament::badge icon="heroicon-m-square-3-stack-3d" icon-position="after" />
                Matching Bonus
            </div>
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'referrals'" :href="$this->query('referrals')" tag="a">
            <div class="flex gap-2 items-center justify-center">
                <x-filament::badge icon="heroicon-m-user-group" icon-position="after" />
                Referrals
            </div>
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'team_volume'" :href="$this->query('team_volume')" tag="a">
            <div class="flex gap-2 items-center justify-center">
                <x-filament::badge icon="heroicon-m-table-cells" icon-position="after" />
                Team Volume Reward
            </div>
        </x-filament::tabs.item>
    </x-filament::tabs>

    <x-filament::section>
        <x-slot name="heading">
            <div class="flex justify-between">
                Levels
                <x-filament::button x-on:click="showModal"
                >
                    Add Level
                </x-filament::button>
            </div>
        </x-slot>

        {{ $this->table }}
    </x-filament::section>

    <x-filament::modal id="team-volume-modal">
        <x-slot name="heading">
            Level Setting
        </x-slot>
        <form action="">
            {{ $this->teamVolumeForm }}
        </form>
        <x-slot name="footerActions">
            <x-filament::button wire:click="submit" type="submit">
                <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="submit" />
                Submit
            </x-filament::button>

            <x-filament::button outlined x-on:click="$dispatch('close-modal', { id: 'team-volume-modal' })">
                close
            </x-filament::button>
        </x-slot>
    </x-filament::modal>

    <x-filament::modal id="commission-modal">
        <x-slot name="heading">
            Add Level Setting
        </x-slot>

        <form action="">
            {{ $this->referralForm }}
        </form>
        

        <x-slot name="footerActions">
            <x-filament::button wire:click="submit" type="submit">
                <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="submit" />
                Submit
            </x-filament::button>

            <x-filament::button outlined x-on:click="$dispatch('close-modal', { id: 'commission-modal' })">
                close
            </x-filament::button>
        </x-slot>
    </x-filament::modal>


</x-filament-panels::page>

@script
<script>
    Alpine.data('commissions', () => ({
        activeTab : $wire.entangle('activeTab'),
        showModal(){
            if(this.activeTab == 'team_volume') return this.$dispatch('open-modal', { id: 'team-volume-modal' });
                    
            this.$dispatch('open-modal', { id: 'commission-modal' });
                    
        }
    }));
</script>
@endscript
