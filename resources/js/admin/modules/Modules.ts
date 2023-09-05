import RunnableModules from "../../abstracts/RunnableModules";
import SoftDeleteRestore from "./soft-delete-restore/SoftDeleteRestore";
import CategorySelection from "./category-selection/CategorySelection";
import ButtonGotoItem from "./button-goto-item/ButtonGotoItem";
import FormActionButtons from "./form-action-buttons/FormActionButtons";

export default class Modules extends RunnableModules {
    constructor() {
        super([
            new SoftDeleteRestore(),
            new CategorySelection(),
            new ButtonGotoItem(),
            new FormActionButtons()
        ]);
    }
}
