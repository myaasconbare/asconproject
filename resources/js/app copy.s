import './bootstrap';
// import Alpine from 'alpinejs'




Alpine.store('utils', {
    showResponse({ type, payload }) {
        console.log(payload);
        return typeof payload == 'string' ? toastr[type](payload) : this.showValidationErrors({type, payload});
    },
    async loopMessages(type, errors){
        for (let j = 0; j < errors.length; j++) {
            this.showResponse({ type: type || 'error', payload: errors[j] });
            await sleep(500);
        }
    },
    async showValidationErrors({ type, payload }) {
        let errorIndices = Object.values(payload);

        if(Array.isArray(errorIndices)) return this.loopMessages(type, errorIndices);

        for (let i = 0; i < errorIndices.length; i++) {
            let errors = errorIndices[i];
            this.loopMessages(type, errors);
        }
    },
    handleServerMsg([response]) {
        console.log(response);
        switch (response.type) {
            case 'validation_error':
                return this.showValidationErrors(response);
            default:
                return this.showResponse(response);
        }
    }
});



// Alpine.start();

window.sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
