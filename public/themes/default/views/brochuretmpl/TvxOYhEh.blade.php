<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A simple image cropping tool.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, jQuery plugin, image cropping, front-end, frontend, web development">
    <meta name="author" content="Fengyuan Chen">
    <title>Image Cropper - Fengyuan Chen</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../assets/css/prettify.css">
    <link rel="stylesheet" href="../dist/cropper.min.css">
    <link rel="stylesheet" href="css/docs.css">
</head>
<body>
    <!-- header -->
    <header class="navbar navbar-static-top docs-navbar-top" id="top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="javascript:void(0);" class="navbar-brand">Cropper</a>
            </div>
            <nav class="collapse navbar-collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li><a href="#overview">Overview</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#getting-started">Getting started</a></li>
                    <li><a href="//github.com/fengyuanchen/cropper">Github</a></li>
                    <li><a href="//github.com/fengyuanchen/cropper/blob/master/LICENSE">License</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="//github.com/fengyuanchen/">About</a></li>
                    <li><a href="/">More</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Banner -->
    <div class="jumbotron docs-jumbotron">
        <div class="container">
            <h1>Image Cropper</h1>
            <p>A simple image cropping tool.</p>
            <p>
                <a href="//github.com/fengyuanchen/cropper/zipball/master" class="btn btn-primary">Download</a>
                <a href="//github.com/fengyuanchen/cropper" class="btn btn-primary">View on Github</a>
            </p>
        </div>
    </div>

    <!-- content -->

    <!-- Overview -->
    <div class="container docs-overview">
        <h1 class="page-header" id="overview">Overview</h1>
        <div class="row">
            <div class="col-md-9">
                <h3>Image:</h3>
                <div class="img-container"><img src="img/picture-1.jpg"></div>
            </div>
            <div class="col-md-3">
                <h3>Preview:</h3>
                <div class="row">
                    <div class="col-md-8">
                        <div class="img-preview img-preview-sm"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="img-preview img-preview-xs"></div>
                    </div>
                </div>
                <hr>
                <h3>Data:</h3>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="data-x1" class="col-sm-3 control-label">X1:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="data-x1" placeholder="x1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-y1" class="col-sm-3 control-label">Y1:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="data-y1" placeholder="y1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-x2" class="col-sm-3 control-label">X2:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="data-x2" placeholder="x2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-y2" class="col-sm-3 control-label">Y2:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="data-y2" placeholder="y2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-width" class="col-sm-3 control-label">Width:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="data-width" placeholder="width">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-height" class="col-sm-3 control-label">Height:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="data-height" placeholder="height">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="docs-btn-group">
                    <h3>Methods:</h3>
                    <div class="button-group">
                        <button class="btn btn-success" id="enable" type="button">Enable</button>
                        <button class="btn btn-danger" id="disable" type="button">Disable</button>
                        <button class="btn btn-info" id="free-ratio" type="button">Free Ratio</button>
                        <button class="btn btn-primary" id="set-data" type="button" title="Set with the following data">Set Data</button>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">X1</span>
                                <input class="form-control" id="set-data-x1" type="number" value="480">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Y1</span>
                                <input class="form-control" id="set-data-y1" type="number" value="60">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Width</span>
                                <input class="form-control" id="set-data-width" type="number" value="640">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Height</span>
                                <input class="form-control" id="set-data-height" type="number" value="360">
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input class="form-control" id="get-data-input" type="text" placeholder="The data object will be showed here">
                        <span class="input-group-btn">
                            <button class="btn btn-info" id="get-data" type="button">Get Data</button>
                        </span>
                    </div>
                    <div class="input-group">
                        <input id="get-img-info-input" type="text" class="form-control" placeholder="The image information will be showed here">
                        <span class="input-group-btn">
                            <button class="btn btn-info" id="get-img-info" type="button">Get Image Info</button>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input id="set-aspect-ratio-input" type="number" class="form-control" placeholder="Input the new aspect ratio here">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="set-aspect-ratio" type="button">Set Aspect Ratio</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input id="set-img-src-input" type="text" class="form-control" placeholder="Input the new image src here" value="img/picture-2.jpg">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="set-img-src" type="button">Set Image Src</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Events:</h3>
                <p>Current active event:</p>
                <div class="btn-group btn-group-justified">
                    <a class="btn btn-default" id="drag-start" role="button" disabled>dragstart</a>
                    <a class="btn btn-default" id="drag-move" role="button" disabled>dragmove</a>
                    <a class="btn btn-default" id="drag-end" role="button" disabled>dragend</a>
                </div>
            </div>
        </div>
        <div class="sources">
            <h3>Sources:</h3>
            <p>HTML:</p>
            <pre class="prettyprint">...
&lt;div class=&quot;img-container&quot;&gt;
    &lt;img src=&quot;img/picture-1.jpg&quot;&gt;
&lt;/div&gt;
...
&lt;div class=&quot;img-preview&quot;&gt;&lt;/div&gt;
...</pre>
            <p>Javascript:</p>
            <pre class="prettyprint">var $image = $(&quot;.img-container img&quot;),
    $dataX1 = $(&quot;#data-x1&quot;),
    $dataY1 = $(&quot;#data-y1&quot;),
    $dataX2 = $(&quot;#data-x2&quot;),
    $dataY2 = $(&quot;#data-y2&quot;),
    $dataHeight = $(&quot;#data-height&quot;),
    $dataWidth = $(&quot;#data-width&quot;);

$image.cropper({
    aspectRatio: 16 / 9,
    preview: &quot;.img-preview&quot;,
    done: function(data) {
        $dataX1.val(data.x1);
        $dataY1.val(data.y1);
        $dataX2.val(data.x2);
        $dataY2.val(data.y2);
        $dataHeight.val(data.height);
        $dataWidth.val(data.width);
    }
});

...

$(&quot;#disable&quot;).click(function() {
    $image.cropper(&quot;disable&quot;);
});

...

$(&quot;#free-ratio&quot;).click(function() {
    $image.cropper(&quot;setAspectRatio&quot;, &quot;auto&quot;);
});

...

var $dragmove = $(&quot;#drag-move&quot;);

$image.on(&quot;dragmove&quot;, function() {
    $dragmove.addClass(&quot;btn-info&quot;).siblings().removeClass(&quot;btn-info&quot;);
});

...</pre>
        </div>
    </div>

    <!-- Features -->
    <div class="container">
        <h1 class="page-header" id="features">Features</h1>
        <ul>
            <li>Support touch</li>
            <li>Support setup</li>
            <li>Support methods</li>
            <li>Support events</li>
            <li>Cross Browsers</li>
        </ul>
    </div>

    <!-- Getting started -->
    <div class="container docs-getting-started">
        <h1 class="page-header" id="getting-started">Getting started</h1>
        <div class="row">
            <div class="col-md-9">
                <!-- Installation -->
                <h2 class="page-header" id="installation">Installation</h2>
                <p>Include files:</p>
                <pre class="prettyprint">&lt;script src=&quot;/path/to/jquery.js&quot;&gt;&lt;/script&gt;&lt;!-- jQuery is required --&gt;
&lt;link  href=&quot;/path/to/cropper.css&quot; rel=&quot;stylesheet&quot;&gt;
&lt;script src=&quot;/path/to/cropper.js&quot;&gt;&lt;/script&gt;</pre>

                <!-- Usage -->
                <h2 class="page-header" id="usage">Usage</h2>
                <p>Initialize with <code>$.fn.cropper</code> method.</p>
                <p>HTML:</p>
                <pre class="prettyprint">&lt;img class=&quot;cropper&quot; src=&quot;img/picture-1.jpg&quot;&gt;</pre>
                <p>Javascript:</p>
                <pre class="prettyprint">$(&quot;.cropper&quot;).cropper({
    aspectRatio: 1.618,
    done: function(data) {
        console.log(data);
    }
});</pre>

                <!-- Options -->
                <h2 class="page-header" id="options">Options</h2>
                <p>Setup with <code>$(&quot;#target&quot;).cropper(options)</code>, or global setup with <code>$.fn.cropper.setDefaults(options)</code>.</p>
                <p class="alert alert-info">Some options can be passed via data attributes by append the option name to <code>data-</code>, as in <code>data-aspect-ratio="2"</code>.</p>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Default</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>aspectRatio</td>
                            <td>number</td>
                            <td>1</td>
                            <td>The aspect ratio of the cropping zone. (e.g., "2", "1.5", "0.618" etc.)</td>
                        </tr>
                        <tr>
                            <td>data</td>
                            <td>object</td>
                            <td>{}</td>
                            <td>
                                <p>Options: "x1", "y1", "width", "height", "x2", "y2".</p>
                                <p>It's possible to save the data in cookie or other where when a page is unload / abort, and then when the page is reload, get the data and re-render it.</p>
                            </td>
                        </tr>
                        <tr>
                            <td>done</td>
                            <td>function</td>
                            <td>function(data) {}</td>
                            <td>The function will be passed a object data and run when the cropping zone was moving.</td>
                        </tr>
                        <tr>
                            <td>modal</td>
                            <td>boolean</td>
                            <td>true</td>
                            <td>Show (true) or hide (false) the black modal layer.</td>
                        </tr>
                        <tr>
                            <td>preview</td>
                            <td>string</td>
                            <td>""</td>
                            <td>A jQuery selector string, add extra elements to show preview.</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Methods -->
                <h2 class="page-header" id="methods">Methods</h2>
                <h4>enable</h4>
                <ul>
                    <li>Enable the cropper.</li>
                    <li>Usage: <code>$("#target").cropper("enable")</code></li>
                </ul>
                <h4>disable</h4>
                <ul>
                    <li>Disable the cropper.</li>
                    <li>Usage: <code>$("#target").cropper("disable")</code>.</li>
                </ul>
                <h4>getData</h4>
                <ul>
                    <li>Get the current cropped zone data.</li>
                    <li>Usage: <code>$("#target").cropper("getData")</code>.</li>
                </ul>
                <h4>setData</h4>
                <ul>
                    <li>Reset the cropping zone with new data.</li>
                    <li>Param: a object contains "x1", "y1", "width", "height", "x2"(optional), "y2"(optional).</li>
                    <li>Usage: <code>$("#target").cropper("setData", {width: 480, height: 270})</code>.</li>
                </ul>
                <h4>setAspectRatio</h4>
                <ul>
                    <li>Enable to reset the aspect ratio after initialization.</li>
                    <li>Param: "auto" or a positive number.</li>
                    <li>Usage: <code>$("#target").cropper("setAspectRatio", 1.618)</code>.</li>
                </ul>
                <h4>setImgSrc</h4>
                <ul>
                    <li>Change the src of the image if need.</li>
                    <li>Usage: <code>$("#target").cropper("setImgSrc", "example.jpg")</code>.</li>
                </ul>
                <h4>getImgInfo</h4>
                <ul>
                    <li>Get the image information, contains: "naturalWidth", "naturalHeight", "width", "height", "aspectRatio", "ratio".</li>
                    <li>The "aspectRatio" is the value of "naturalWidth / naturalHeight".</li>
                    <li>The "ratio" is the value of "width / naturalWidth".</li>
                    <li>Usage: <code>$("#target").cropper("getImgInfo")</code>.</li>
                </ul>

                <!-- Events -->
                <h2 class="page-header" id="events">Events</h2>
                <h4>dragstart</h4>
                <p>This event will be triggered before the cropping zone start to move.</p>
                <h4>dragmove</h4>
                <p>This event will be triggered when the cropping zone was moving.</p>
                <h4>dragend</h4>
                <p>This event will be triggered after the cropping zone stop to move.</p>
            </div>
            <div class="col-md-3">
                <div class="hidden-print docs-sidebar" role="complementary">
                    <ul class="nav">
                        <li><a href="#installation">Installation</a></li>
                        <li><a href="#usage">Usage</a></li>
                        <li><a href="#options">Options</a></li>
                        <li><a href="#methods">Methods</a></li>
                        <li><a href="#events">Events</a></li>
                    </ul>
                    <a class="btn btn-link back-to-top" href="#top">Back to top</a>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="docs-footer">
        <div class="container">
            <div class="btn-group">
                <a class="btn btn-link" href="//github.com/fengyuanchen/cropper/">Github</a>
                <a class="btn btn-link" href="//github.com/fengyuanchen/cropper/blob/master/LICENSE">License</a>
                <a class="btn btn-link" href="//github.com/fengyuanchen/">About</a>
            </div>
            <div class="btn-group pull-right">
                <a class="btn btn-link" href="#top" title="Back to top">Back to top</a>
            </div>
        </div>
    </footer>

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/vendor/jquery/jquery-1.11.0.min.js"><\/script>')</script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!--<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    <script>window.prettyPrint || document.write('<script src="../assets/js/prettify.js"><\/script><link rel="stylesheet" href="../assets/css/prettify.css">')</script>
    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script> -->
    <script src="../assets/js/prettify.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../dist/cropper.min.js"></script>
    <script>
        $(function() {
            var $image = $(".img-container img"),
                $dataX1 = $("#data-x1"),
                $dataY1 = $("#data-y1"),
                $dataX2 = $("#data-x2"),
                $dataY2 = $("#data-y2"),
                $dataHeight = $("#data-height"),
                $dataWidth = $("#data-width"),
                $dragStart = $("#drag-start"),
                $dragMove = $("#drag-move"),
                $dragEnd = $("#drag-end");

            $image.cropper({
                aspectRatio: 16 / 9,
                preview: ".img-preview",
                done: function(data) {
                    $dataX1.val(data.x1);
                    $dataY1.val(data.y1);
                    $dataX2.val(data.x2);
                    $dataY2.val(data.y2);
                    $dataHeight.val(data.height);
                    $dataWidth.val(data.width);
                }
            }).on({
                dragstart: function() {
                    $dragStart.addClass("btn-info").siblings().removeClass("btn-info");
                },
                dragmove: function() {
                    $dragMove.addClass("btn-info").siblings().removeClass("btn-info");
                },
                dragend: function() {
                    $dragEnd.addClass("btn-info").siblings().removeClass("btn-info");
                }
            });

            $("#enable").click(function() {
                $image.cropper("enable");
            });

            $("#disable").click(function() {
                $image.cropper("disable");
            });

            $("#free-ratio").click(function() {
                $image.cropper("setAspectRatio", "auto");
            });

            $("#get-data").click(function() {
                var data = $image.cropper("getData"),
                    val = "";

                try {
                    val = JSON.stringify(data);
                } catch (e) {
                    console.log(data);
                }

                $("#get-data-input").val(val);
            });

            var $setDataX1 = $("#set-data-x1"),
                $setDataY1 = $("#set-data-y1"),
                $setDataWidth = $("#set-data-width"),
                $setDataHeight = $("#set-data-height");

            $("#set-data").click(function() {
                var data = {
                    x1: $setDataX1.val(),
                    y1: $setDataY1.val(),
                    width: $setDataWidth.val(),
                    height: $setDataHeight.val(),
                }

                $image.cropper("setData", data);
            });

            $("#set-aspect-ratio").click(function() {
                var aspectRatio = $("#set-aspect-ratio-input").val();

                $image.cropper("setAspectRatio", aspectRatio);
            });

            $("#set-img-src").click(function() {
                var cropper = $image.data("cropper"),
                    val = $("#set-img-src-input").val();

                if (val === "img/picture-2.jpg") {
                    cropper.defaults.data = {
                        y1: 30
                    };
                } else {
                    cropper.defaults.data = {};
                }

                $image.cropper("setImgSrc", val);
            });

            $("#get-img-info").click(function() {
                var data = $image.cropper("getImgInfo"),
                    val = "";

                try {
                    val = JSON.stringify(data);
                } catch (e) {
                    console.log(data);
                }

                $("#get-img-info-input").val(val);
            });

            var $sidebar = $(".docs-sidebar"),
                offset = $sidebar.offset();

            $(window).bind("scroll", function() {
                var st = $(this).scrollTop();

                if (st > offset.top) {
                    $sidebar.addClass("fixed");
                } else {
                    $sidebar.removeClass("fixed");
                }
            });
        });
    </script>
</body>
</html>
