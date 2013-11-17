<?php
    function sa($item){
        if(URL::to($item) == URL::full() ){
            return  'class="active"';
        }else{
            return '';
        }
    }
?>
<ul class="nav">
    @if(Auth::check())
        <li><a href="{{ URL::to('music') }}" {{ sa('music') }} >Music</a></li>
        <li><a href="{{ URL::to('artist') }}" {{ sa('artist') }} >Artist</a></li>
        <li><a href="{{ URL::to('album') }}" {{ sa('album') }} >Album</a></li>
        <li><a href="{{ URL::to('document') }}" {{ sa('document') }} >Documents</a></li>
    @endif
</ul>
