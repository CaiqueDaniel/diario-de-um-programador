import RunnableModules from "../../abstracts/RunnableModules";
import SoftDeleteRestore from "./soft-delete-restore/SoftDeleteRestore";
import CategorySelection from "./category-selection/CategorySelection";

export default class Modules extends RunnableModules {
    constructor() {
        super([
            new SoftDeleteRestore(),
            new CategorySelection()
        ]);
    }
}
