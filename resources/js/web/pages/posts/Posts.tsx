import RunnableModules from "../../../abstracts/RunnableModules";
import {CodeParser} from "./components/CodeParser";

export default class Posts extends RunnableModules {
    constructor() {
        super([
            new CodeParser()
        ]);
    }
}
