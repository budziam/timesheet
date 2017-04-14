<ol class="breadcrumb">
    @foreach($breadcrumbs as $breadcrumb)
        <li class="breadcrumb-item">
            {!! Html::link($breadcrumb->getUrl(), str_limit($breadcrumb->getName(), 32), [
                'title' => $breadcrumb->getName(),
            ]) !!}
        </li>
    @endforeach
</ol>