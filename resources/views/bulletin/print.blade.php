<!DOCTYPE html>
<html>

<head>
    <title>Impression bulletin</title>
</head>

<body>

    <img src="{{ $bulletin->image_base64 }}" style="width:100%;">

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>
