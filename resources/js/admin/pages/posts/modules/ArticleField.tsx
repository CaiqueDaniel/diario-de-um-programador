import {Runnable} from '../../../interfaces';
import Quill from 'quill';

export default class ArticleField implements Runnable {
    public run(): void {
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],

            [{'header': 1}, {'header': 2}],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'script': 'sub'}, {'script': 'super'}],
            [{'indent': '-1'}, {'indent': '+1'}],
            [{'direction': 'rtl'}],

            [{'size': ['small', false, 'large', 'huge']}],
            [{'header': [1, 2, 3, 4, 5, 6, false]}],

            [{'color': []}, {'background': []}],
            [{'font': []}],
            [{'align': []}],

            ['clean']
        ];


        const articleInput = document.getElementById('article') as HTMLInputElement;
        const quill = new Quill('#article-root', {
            theme: 'snow',
            modules: {syntax: false, toolbar: toolbarOptions}
        });

        quill.root.innerHTML = articleInput.value;
        quill.on('editor-change', () => articleInput.value = quill.root.innerHTML);
    }
}
