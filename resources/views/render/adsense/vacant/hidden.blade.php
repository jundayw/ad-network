<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AdNetWork</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<img style="display: none;" src="{{ $hidden['callback'] }}">
<script>
    window.parent.postMessage({
        action: 'hidden',
        element: '{{ $request->get('ne') }}',
        hidden: '{{ $hidden['hidden'] }}',
    }, '*');
</script>
</body>
</html>
