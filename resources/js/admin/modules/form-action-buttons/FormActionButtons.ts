import {Runnable} from "../../../interfaces";

export default class FormActionButtons implements Runnable {
    public run(): void {
        const formActionButtons = document.getElementById('form-action-buttons');
        const form = formActionButtons?.closest('form');

        if (!formActionButtons || !form)
            return;

        const submitButton = formActionButtons.querySelector<HTMLButtonElement>('button[type="submit"]');
        const goBackButton = formActionButtons.querySelector<HTMLAnchorElement>('a.btn-secondary');

        if (!submitButton)
            return;

        form.addEventListener('submit', () => {
            submitButton.disabled = true;
            submitButton.classList.add('disabled');

            goBackButton?.classList.add('disabled');

            submitButton.querySelector('.spinner-grow')?.classList.remove('d-none');
        });
    }
}
