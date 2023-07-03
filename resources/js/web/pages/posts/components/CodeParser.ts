import Prism from "prismjs";

import {Runnable} from "../../../../interfaces";

import 'prismjs/components/prism-markup-templating'

import 'prismjs/components/prism-markup';
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-css';

import 'prismjs/plugins/toolbar/prism-toolbar';
import 'prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard';

export class CodeParser implements Runnable {
    public run(): void {
        Prism.highlightAll();
    }
}
