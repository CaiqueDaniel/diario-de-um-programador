import RunnableModules from "../../abstracts/RunnableModules";
import Posts from "./posts/Posts";

export default class Pages extends RunnableModules {
    constructor() {
        super([
            new Posts()
        ]);
    }
}
