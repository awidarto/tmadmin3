@extends('layout.brochure')

@section('content')
<style type="text/css">
    #head{
        display: block;
        width: 100%;
    }

    #head img{
        width:100%;
        height: auto;
    }

    #subhead{
        display: block;
    }

    #subhead .subimage{
        width:30%;
        float: left;
        display: block;
    }

    #subhead .subimage img{
        width:100%;
        height: auto;
    }

</style>
<page>
    <div id="head">
        {{ HTML::image($prop['defaultpictures']['brchead'])}}
    </div>
    <div id="subhead">
        <div class="subimage">
            {{ HTML::image($prop['defaultpictures']['brc1'])}}
        </div>
        <div class="subimage">
            {{ HTML::image($prop['defaultpictures']['brc2'])}}
        </div>
        <div class="subimage">
            {{ HTML::image($prop['defaultpictures']['brc3'])}}
        </div>
    </div>
    <h1>Exemple d'utilisation</h1>
    <br>
    Ceci est un <b>exemple d'utilisation</b>
    de <a href='http://html2pdf.fr/'>HTML2PDF</a>.<br>
</page>"
@stop