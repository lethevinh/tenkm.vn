<title>{{$title}}</title>
<meta name='description' itemprop='description' content='{{$description}}' />
<meta name='keywords' content='{{$keyword}}' />
<meta property='article:published_time' content="{{$published_time??'2015-01-31T20:30:11-02:00'}}" />
<meta property='article:section' content='news' />
<link rel="shortcut icon" href="/assets/ico/favicon.ico">
<meta property="og:description" content="{{$description}}" />
<meta property="og:title" content="{{$title}}" />
<meta property="og:url" content="{{route('home.show')}}" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:locale:alternate" content="vi_VN" />
<meta property="og:locale:alternate" content="vi_VN" />
<meta property="og:site_name" content="{{option('name', '')}}" />
<meta property="og:image" content="{{$image}}" />
<meta property="og:image" content="{{$image}}" />
<meta property="og:image:url" content="{{$image}}" />
<meta property="og:image:size" content="300" />
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Article","name":"{{$title}}"}</script>
