import RunnableModules from "../abstracts/RunnableModules";
import PostForm from "./posts/PostForm";

export default class Pages extends RunnableModules {
    constructor() {
        super([]);
    }

    public override run(): void {
        //Todo: Refator this
        if (document.getElementById('post-form'))
            Pages.invoke(new PostForm())
    }
}
