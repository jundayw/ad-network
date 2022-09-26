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
<script>
    window.parent.postMessage({
        action: 'hidden',
        element: '{{ $request->get('ne') }}',
        hidden: 'hidden-{{ $request->get('data-ad-client') }}-{{ $request->get('data-ad-slot') }}',
    }, '*');
</script>
</body>
</html>
