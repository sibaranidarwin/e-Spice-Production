<ul id="myUL">
    @foreach ($good_receipts as $data)
        <li><a href="{{ route('vendor.index', $data->id) }}"><span style="color:#737373;padding-right:1em;" class="glyphicon glyphicon-folder-open"></span> {{ $data->perihal }}  <span class="from">dari</span>  {{ $data->pengirim }}</a></li>
         @endforeach
    </ul>