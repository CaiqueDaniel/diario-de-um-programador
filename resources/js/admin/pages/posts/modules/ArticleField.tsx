import {Runnable} from "../../../interfaces";
import Quill from "quill";

export default class ArticleField implements Runnable {
    public run(): void {
        const articleInput = document.getElementById('article') as HTMLInputElement;
        const quill = new Quill('#article-root', {theme: 'snow'});

        quill.root.innerHTML = articleInput.value;
        quill.on('text-change', () => articleInput.value = quill.root.innerHTML);
    }
}
