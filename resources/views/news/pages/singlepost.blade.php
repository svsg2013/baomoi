@extends('news/layout/single')
@section('metaJson')
	<meta property="og:site_name" content="{{url('/')}}" />
	<meta property="og:rich_attachment" content="true" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{url()->current()}}" />
	<meta property="og:title" content="{{$post->title}}" />
	<meta property="og:description" content="{{$post->description}}" />
	<meta property="og:image:url" content="{{url('/').'/'.$post->feture}}" />
	<meta property="og:image:width" content="720" />
	<meta property="og:image:height" content="378" />
	<meta property="article:published_time" content="{{date('d-m-Y', strtotime($post->created_at))}}" />
	<meta property="article:section" content="Bóng đá Việt Nam" />
	@foreach($post->tags as $tag)
		<meta property="article:tag" content="{{$tag->name}}"/>
	@endforeach


<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Blog",
	  "author":{
		"@type": "Person",
		"name":"{{$post->admin->name}}"
	  },
	  "thumbnailUrl":"{{url('/').'/'.$post->feture}}",
	  "url":"http://quanque.000webhostapp.com",
	  "headline":"{{$post->title}}",
	  "accessibilitySummary":"{{$post->description}}",
			"keywords":"
				@foreach($post->tags as $tag)
					{{$tag->name.','}}
				@endforeach
			",
			"isBasedOn":"{{url()->current()}}",
			"dateCreated":"{{date('d-m-Y', strtotime($post->created_at))}}"
	}
</script>
@endsection
@section('content')
@if(isset($post))
@section('title')
| {{ $post->title }}
@endsection
	@if($post->post_type == 'text')
	<a href="" class="featured-img">
		@if($post->feture)
			<?php $image = $post->feture; ?>
		@else 
			<?php $image = 'http://placehold.it/620x375'; ?>
		@endif
		<img src="{{$image}}" alt="">
	</a>
	@endif
	<!-- Youtube Video embed -->
	@if($post->post_type == 'video')
	<div class="flex-video widescreen">
		<video src="{{ $post->feture}}" style="width: 100%" controls></video>
	</div>
	@endif
	<!-- End Youtube Video embed -->

	<h1 class="post-title">{{ $post->title }}</h1>

	 {!!  $post->content !!}

	<div class="post-meta">
		<span class="view"><a href="">{{$post->view}} views</a></span>
		<span class="author"><a href="author/{{ $post->admin->name }}">{{ $post->admin->name }}</a></span>
		<span class="date"><a href="">{{date('H:i d-m-Y', strtotime($post->created_at)) }}</a></span>
		<li class="widget widget_tag_cloud clearfix">
			<div class="tagcloud">
				<h3 style="float: left; margin: 0;margin-right: 10px; font-size: 18px; margin-top: 5px;">Tags:</h3>
				@foreach($post->tags as $tag)
					{{$tagKey=$tag->name}}
					<a href="tag/{{ $tag->name }}" title="3 topics" style="font-size: 22pt;">{{ $tag->name }}</a>
				@endforeach
			</div>
		</li>
	</div>

	<div class="social-media clearfix">
		<ul>
			<li class="twitter">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="{{ $post->slug }}" data-text="">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</li>
			<li class="facebook">
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>
				<div class="fb-like" data-href="http://www.nextwpthemes.com/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
			</li>
			<li class="google_plus">
				<div class="g-plusone" data-size="medium"></div>
				<script type="text/javascript">
				  (function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
			</li>
		</ul>
	</div>

	<div class="clear"></div>

	<div class="line"></div>

	<h4 class="post-title">Bình Luận</h4>
	<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=863868720428280";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class="fb-comments" data-href="{{url($post->slug)}}" data-numposts="5" data-width="100%"></div>
	<br>
	<h4 class="post-title">Tin Khác</h4>
	<ul class="arrow-list">
		@foreach($lq as $post)
			<li>
				<a href="{{ $post->slug }}">{{ $post->title }}</a>
			</li>
		@endforeach
	</ul>
@else
<section class="row">
	<article class="post ten column">
		<h3>Bài viết không tồn tại.</h3>
	</article>
</section>
@section('title')
| Không tìm thấy
@endsection
@endif
@endsection