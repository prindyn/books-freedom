<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/epubjs/dist/epub.min.js"></script>

    <style type="text/css">
        .epub-container {
            min-width: 320px;
            margin: 0 auto;
            position: relative;
        }

        .epub-container .epub-view>iframe {
            background: white;
            box-shadow: 0 0 4px #ccc;
            margin: 10px;
            padding: 20px;
        }

    </style>
</head>

<body>
    <div id="viewer"></div>
    <script>
        var currentSectionIndex = 8;
        // Load the opf
        var book = ePub("varta_u_gri.epub");
        var rendition = book.renderTo(document.body, {
            manager: "continuous",
            flow: "scrolled",
            width: "60%"
        });
        var displayed = rendition.display();
        // var displayed = rendition.display("epubcfi(/1/14[xchapter_001]!4/2/24/2[c001p0011]/1:799)");


        displayed.then(function(renderer) {
            // -- do stuff
        });

        // Navigation loaded
        book.loaded.navigation.then(function(toc) {
            // console.log(toc);
        });
    </script>

</body>

</html>
