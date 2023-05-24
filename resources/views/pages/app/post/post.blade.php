@extends('layouts.app')

@section('content')
    <div class="container mt-4 w-md-50">
        <h1>Titulo do artigo</h1>
        <h3>Descrição do artigo</h3>

        <div class="col-12">
            <img src="https://dummyimage.com/1400x400/000/fff.png" class="d-block w-100" loading="lazy"
                 alt="...">
        </div>

        <article class="mt-4" style="text-align: justify">
            <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum felis quis egestas mollis. Nulla consectetur sapien non tempus tempus. Maecenas at ligula sit amet lorem luctus tempor. Sed convallis tempus sapien, eget bibendum magna sagittis sed. Ut lacus libero, placerat ac porttitor eu, consectetur vitae mi. Aliquam sollicitudin eget tortor at pretium. Integer tristique vestibulum justo, eleifend lacinia tellus. Nunc eros nunc, placerat in nunc sed, volutpat semper nisl. Vestibulum quis enim in sapien fringilla porttitor.

            Quisque rhoncus luctus risus, vel finibus orci rutrum sed. Phasellus tristique vehicula lectus, ac accumsan velit eleifend eget. Nulla volutpat dapibus dapibus. In felis diam, hendrerit et hendrerit in, euismod tincidunt enim. Nulla eleifend eros mi, ac lacinia dui suscipit ut. In porttitor imperdiet arcu a fringilla. Nam lorem metus, laoreet sit amet nibh vitae, malesuada consequat felis.

            Quisque eget enim quis quam tristique rutrum. Curabitur ut volutpat nisl. Aenean condimentum hendrerit lacus vitae pulvinar. Quisque varius lectus at pharetra rutrum. Etiam tristique eu dui scelerisque egestas. Duis lorem lectus, auctor nec lacus quis, elementum convallis nisl. Etiam a ante fermentum, maximus velit id, viverra leo. Nulla facilisi. Vestibulum suscipit laoreet turpis id semper. Quisque ut diam tempus, pharetra orci at, ornare turpis. Integer consectetur, tellus id aliquam pellentesque, augue neque consequat orci, sed aliquam lectus nibh ac nisi. Sed pellentesque vulputate quam, in venenatis odio facilisis eget.

            Ut varius et urna aliquam venenatis. Curabitur elementum mauris ligula, quis euismod erat finibus et. Donec scelerisque vehicula gravida. Maecenas consequat sem et arcu pellentesque, semper malesuada arcu suscipit. Maecenas ipsum dolor, ornare vel rhoncus at, efficitur consequat leo. Vestibulum accumsan orci neque, ut varius sapien dignissim eu. Nulla facilisi. Vivamus mollis nunc at justo dictum convallis. Pellentesque tincidunt lorem sit amet massa vulputate venenatis. Ut quis lacinia odio. Donec rhoncus arcu congue nisl tristique convallis. Phasellus et massa sit amet orci bibendum tempus quis et dolor. Nam eget facilisis dolor.

            Morbi vitae lectus lacus. Vestibulum finibus mi semper augue scelerisque, eu rutrum mauris mattis. Phasellus id est tincidunt, semper est et, luctus risus. Donec ut eleifend tellus. Nunc sed est lacus. Duis placerat massa tempor sem congue, in viverra leo facilisis. Quisque interdum risus sed orci iaculis, viverra molestie purus gravida.
            </p>
        </article>

        <x-posts.listing-post title="Artigos Relacionados"/>
    </div>
@endsection
