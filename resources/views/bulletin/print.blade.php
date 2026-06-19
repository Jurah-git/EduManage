<!DOCTYPE html>
<html>

<head>
    <title>Impression bulletin</title>
</head>
<style>
    @media print {

        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        body * {
            visibility: hidden;
        }

        #zone-print,
        #zone-print * {
            visibility: visible;
        }

        #zone-print {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

    }
</style>

<body>
    <div id="zone-print">
        <img src="{{ $bulletin->image_base64 }}"
            style="
        width:100%;
        height:auto;
        max-height:100vh;
        object-fit:contain;
    ">
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
