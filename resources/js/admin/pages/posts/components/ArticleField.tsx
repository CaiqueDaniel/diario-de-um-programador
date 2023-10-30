import React from 'react';
import {Editor} from "@tinymce/tinymce-react";

import 'tinymce/tinymce';

import 'tinymce/themes/silver';
import 'tinymce/models/dom';
import 'tinymce/icons/default';

import 'tinymce/plugins/preview';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/visualchars';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/image';
import 'tinymce/plugins/link';
import 'tinymce/plugins/media';
import 'tinymce/plugins/template';
import 'tinymce/plugins/codesample';
import 'tinymce/plugins/table';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/nonbreaking';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/wordcount';

interface Props {
    input: HTMLInputElement
}

export default function ArticleField(props: Props): JSX.Element {
    const {input} = props;

    const plugins = [
        'preview',
        'searchreplace',
        'autolink',
        'directionality',
        'visualblocks',
        'visualchars',
        'fullscreen',
        'image',
        'link',
        'media',
        'template',
        'codesample',
        'table',
        'charmap',
        'pagebreak',
        'nonbreaking',
        'anchor',
        'insertdatetime',
        'advlist',
        'lists',
        'wordcount'
    ];

    const codesample_languages = [
        {text: 'HTML/XML', value: 'markup'},
        {text: 'JavaScript', value: 'javascript'},
        {text: 'TypeScript', value: 'typescript'},
        {text: 'PHP', value: 'php'},
        {text: 'CSS', value: 'css'},
        {text: 'SCSS', value: 'scss'},
        {text: 'JSON', value: 'json'},
        {text: 'JSX', value: 'jsx'},
        {text: 'Java', value: 'java'},
        {text: 'Bash', value: 'bash'},
    ];

    const handleImageUpload = (blobInfo: any) => {
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        return new Promise<string>((resolve, reject) => {
            window.axios.post<{ location: string }>('/painel/artigos/clipboard', formData)
                .then((response) => resolve(response.data.location))
                .catch(reject);
        });
    }

    const onInput = (value: string) => input.value = value;

    return (
        <>
            <Editor
                onEditorChange={onInput}
                initialValue={input.value}
                init={{
                    branding: false,
                    height: 700,
                    menubar: true,
                    plugins: plugins,
                    toolbar: 'formatselect | bold italic underline strikethrough | forecolor backcolor blockquote | link image media | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | codesample | fullscreen',
                    image_advtab: true,
                    content_css: '/css/tinymce/content.min.css',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif }',
                    automatic_uploads: true,
                    images_replace_blob_uris: true,
                    images_upload_credentials: true,
                    images_upload_handler: handleImageUpload,
                    codesample_languages
                }}
            />
        </>
    );
}
