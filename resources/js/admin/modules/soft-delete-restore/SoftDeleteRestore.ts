import {Runnable} from "../../../interfaces";

export default class SoftDeleteRestore implements Runnable {
    public run() {
        document.querySelectorAll('.listing .form-switch input').forEach((element) => {
            const {dataset, checked} = element as HTMLInputElement;
            let isChecked = checked;

            (element as HTMLInputElement).addEventListener('click', () => {
                const url = isChecked ? dataset.trash : dataset.restore;
                isChecked = !isChecked;

                if (!url)
                    return;

                window.axios.patch(url);
            });
        });
    }
}
