import React from 'react';
import ReactDOM from 'react-dom';

import {Runnable} from "../../../interfaces";
import ArticleField from "./components/ArticleField";

export default class PostForm implements Runnable{
    public run(): void{
        const articleInput = document.getElementById('article') as HTMLInputElement;

        ReactDOM.render(<ArticleField input={articleInput}/>,document.getElementById('article-root'));
    }
}
