import {Runnable} from "../../interfaces";

export default class CategorySelection implements Runnable {
    private btnReset: HTMLButtonElement;
    private static readonly INPUTS_QUERY_SELECTOR = '#category-selection input';

    constructor() {
        this.btnReset = document.getElementById('btn-clear-category-selection') as HTMLButtonElement;
    }

    public run(): void {
        this.addBtnResetEvent();
        this.addRadioInputEvent();
    }

    private addBtnResetEvent(): void {
        this.btnReset.addEventListener('click', () => {
            const inputs = document.querySelectorAll(CategorySelection.INPUTS_QUERY_SELECTOR);

            inputs.forEach((input) => {
                (input as HTMLInputElement).checked = false;
                this.btnReset.style.display = 'none';
            });
        });
    }

    private addRadioInputEvent(): void {
        this.btnReset.style.display = 'none';

        const inputs = document.querySelectorAll(CategorySelection.INPUTS_QUERY_SELECTOR);

        inputs.forEach((input) => {
            if ((input as HTMLInputElement).checked)
                this.btnReset.style.display = 'block';

            (input as HTMLInputElement).addEventListener('input', () => {
                this.btnReset.style.display = 'block';
            });
        });
    }
}
