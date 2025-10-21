import './bootstrap';
import Notiflix from 'notiflix';
import currency from 'currency.js';


window.Notiflix = Notiflix;

Notiflix.Loading.init({
    zindex: 999999,
    backgroundColor: 'rgba(0,0,0,0.8)',
    svgSize: '80px',
    svgColor: '#f9f9f9',
});

document.addEventListener('DOMContentLoaded', () => {
    window.toastr.options.preventDuplicates = true;
    window.toastr.options.progressBar = true;
});

Alpine.store('calculator', {
    showResult() {
        if (!this.amount) throw new Error("Please enter Investment amount");
        if (!this.computedPortolio) throw new Error("Please select a license");
        if (!this.duration) throw new Error("Duration can't be empty!");
        if (isNaN(+this.duration)) throw new Error("Enter a valid duration");

        if (
            +this.amount < +this.computedPortolio.min_amount ||
            !this.computedPortolio.is_unlimited && +this.amount > +this.computedPortolio.max_amount
        ) {
            let rangeStart = money(this.computedPortolio.min_amount);
            let rangeEnd = +this.computedPortolio.is_unlimited ? 'UNLIMITED' : money(this.computedPortolio.max_amount);

            throw new Error(`Amount is out of range for the selected license ${rangeStart} - ${rangeEnd}`)
        }

        let minimumProfit = ((this.computedLicense.minimum_interest_rate / 100) * this.amount) * this.duration;
        let maximumProfit = ((this.computedLicense.maximum_interest_rate / 100) * this.amount) * this.duration;

        let minimumProfitRange = money(+this.amount + minimumProfit);
        let maximumProfitRange = money(+this.amount + maximumProfit);

        if (isNaN(+minimumProfit) || isNaN(+maximumProfit)) return;

        this.profitRange = `${minimumProfitRange} - ${maximumProfitRange}`;
        this.result = `Your current license procures ${money(minimumProfit)} to ${money(maximumProfit)} after ${this.duration} days`;

        return [this.profitRange, this.result];
    }
});

Alpine.store('utils', {
    init() {
        // console.log("{{ session('success') }}");
    },
    showResponse({ type, payload }) {
        return typeof payload == 'string' ?
            toastr[type](payload) :
            this.showValidationErrors({ type, payload });
    },
    async showMessages(type, errors) {
        for (let j = 0; j < errors.length; j++) {
            this.showResponse({ type: type || 'error', payload: errors[j] });
            await sleep(500);
        }
    },
    async showValidationErrors({ type, payload }) {
        let errorIndices = Object.values(payload);

        if (Array.isArray(errorIndices)) return this.showMessages(type, errorIndices);

        for (let i = 0; i < errorIndices.length; i++) {
            let errors = errorIndices[i];
            this.showMessages(type, errors);
        }
    },
    handleServerMsg([response]) {
        return this.showResponse(response);
    },
    determineLicense(amount, licenses) {
        let license = null;

        for (let i = 0; i < licenses.length; i++) {
            let currentLicense = licenses[i];
            let nextLicense = licenses[i + 1] ?? null;

            if (!(amount >= currentLicense.minimum_amount)) continue;

            if (nextLicense && amount >= nextLicense.minimum_amount) continue;

            license = currentLicense;
            break;
        }

        return license;
    }
});

window.Loading = Notiflix.Loading;
window.showLoading = window.Loading.dots;
window.hideLoading = window.Loading.remove;
window.notifySuccess = (msg) => Alpine.store('utils').showResponse({ type: 'success', payload: msg });
window.notifyError = (msg) => Alpine.store('utils').showResponse({ type: 'error', payload: msg });
window.sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
window.currency = currency;
window.money = (n) => currency(n).format();



