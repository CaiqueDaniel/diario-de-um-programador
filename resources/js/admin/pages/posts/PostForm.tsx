import RunnableModules from "../../abstracts/RunnableModules";
import ArticleField from "./modules/ArticleField";

export default class PostForm extends RunnableModules{
    constructor() {
        super([
            new ArticleField()
        ]);
    }
}
