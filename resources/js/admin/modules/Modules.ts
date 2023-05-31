import RunnableModules from "../abstracts/RunnableModules";
import SoftDeleteRestore from "./soft-delete-restore/SoftDeleteRestore";

export default class Modules extends RunnableModules {
    constructor() {
        super([
            new SoftDeleteRestore()
        ]);
    }
}
