<div>
    {{-- The Master doesn't talk, he acts. --}}
</div>


@script
<script>
    Alpine.data('topup', () => ({
        loaded: @entangle('loaded'), 
        expired: @entangle('expired'),
        showApprovedLoader: false,
        approved: @entangle('approved'),
        createdDate: new Date(@js($this->createdAt)),
        countdown: null,
        balance: @js(auth()->user()->topup_balance, 2),

        addMinutes(date, minutes) {
            return new Date(date.getTime() + minutes*60000);
        },
        init(){
            Livewire.on('top-up-approved', () => {

                if(this.approved) return;

                Notiflix.Loading.circle();

                setTimeout(() => {
                    Notiflix.Loading.remove();
                    this.approved = true;
                }, 5000);
            });

     
            let deadline = this.addMinutes(this.createdDate, 20);

            this.countdown = setInterval(() => {
                let now  = new Date().getTime();
                let t = deadline - now;
                let days = Math.floor(t/(1000*60*60*24));
                let hours = Math.floor((t%(1000*60*60*24))/(1000*60*60));
                let minutes = Math.floor((t%(1000*60*60))/(1000*60));
                let seconds = Math.floor((t%(1000*60))/1000);

                let countdownText = this.$refs.countdownText;
                
                if(countdownText) countdownText.innerHTML =  minutes + "m "+ seconds + "s ";
                
                if(t<0){
                    clearInterval(this.countdown);
                }
            
            }, 0);    
        }
    }))
</script>
@endscript