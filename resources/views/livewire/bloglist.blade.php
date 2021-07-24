<!-- blog lists starts -->
<section id="blog-list">
    <div class="container blogList">
        @foreach($bloglist as $blog)
        <div class="card ">
            <div class="row pt-5 ">
                <div class="col-lg-4 pt-5 ">
                    <div class="blog-image  mt-3 ">
                        <img src="img/blogItem1.jpg " alt="blog imgae " class="img-fluid w-100 ">
                    </div>
                </div>
                <div class="col-lg-8 p-5">
                    <div class="blog-text ">
                        <h1 class="text-3xl font-bold">{{$blog->title}}</h1>

                        <p>
                            {!! $blog->content !!}...
                            <a class="text-indigo-600 hover-text-indigo-900" target="_blank" href="{{URL::to('/'.$blog->slug)}}">
                            <span class="readMore ">Continue Reading </span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- blog lists ends -->