import {Runnable} from "../../../interfaces";

export default class ButtonGotoItem implements Runnable {
    public run(): void {
        const disabledClassname = 'disabled';

        document.querySelectorAll('.listing .list-group .item-actions').forEach((element) => {
            const switchInput = element.querySelector<HTMLInputElement>('.form-switch input');
            const btnGotoItem = element.querySelector<HTMLButtonElement>('.btn-go-to-item');

            if (!switchInput || !btnGotoItem)
                return;

            const handleBtnStatus = () => {
                switchInput.checked ?
                    btnGotoItem.classList.remove(disabledClassname) :
                    btnGotoItem.classList.add(disabledClassname);
            }

            handleBtnStatus();

            switchInput.addEventListener('click', handleBtnStatus);
        });
    }
}
