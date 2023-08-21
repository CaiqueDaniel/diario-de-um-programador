import RunnableModules from "../../abstracts/RunnableModules";
import SoftDeleteRestore from "./soft-delete-restore/SoftDeleteRestore";
import CategorySelection from "./category-selection/CategorySelection";
import ButtonGotoItem from "./button-goto-item/ButtonGotoItem";

export default class Modules extends RunnableModules {
    constructor() {
        super([
            new SoftDeleteRestore(),
            new CategorySelection(),
            new ButtonGotoItem()
        ]);
    }
}
