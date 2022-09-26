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

        html, body {
            width: 100%;
            height: 100%;
        }

        .images {
            display: block;
            width: 100%;
            height: 100%;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .logo-container {
            display: block;
            position: absolute;
            right: 0;
            top: 0;
            z-index: 65534;
            font-size: 0;
            line-height: 0;
            width: auto;
            height: 16px;
            overflow: hidden;
            background: #b2b2b2;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0.5;
        }

        .logo-container .gap {
            display: inline-block;
            *display: inline;
            *zoom: 1;
            width: 1px;
            height: 10px;
            line-height: 0;
            background-color: #fff;
            opacity: 0.45;
            margin: 3px 0;
        }

        .logo-link {
            display: inline-block;
            *display: inline;
            *zoom: 1;
            width: auto;
            height: 10px;
            margin: 3px 4px;
        }

        .logo-close-img {
            display: inline-block;
            *display: inline;
            *zoom: 1;
            width: auto;
            height: 10px;
            margin: 3px 4px;
        }
    </style>
@stack('styles')
    <!-- jQuery -->
    <script src="{{ H('plugins/components/jquery/dist/jquery.min.js') }}"></script>
    <!--layer -->
    <script src="{{ H('plugins/components/layer/layer.js') }}"></script>
@stack('scripts')
</head>
<body>
<div class="container">
    @yield('content')
    <div class="logo-container">
        <a href="{{ config('adnetwork.union.link') }}" id="logo-container-wrapper" target="_blank">
            <img class="logo-link"
                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAAAUCAYAAAA0nZtFAAAAAXNSR0IArs4c6QAAA/lJREFUWAnNmFmIjlEYx2esIyTGvlMijezDhYixZ7lhFMp6IbmQrShbcSESibhAslO2C4oRLpQbI5ms2YaJplD2iPH7f86j83297/st8w2e+s0553n+5znnfc95z5yZnJwAq6qqyoejUC8gXKMuxiyCcpiR6UD0XQ8rrD/1RnAQJpovrZKOm0B2Nq2OWRAzZj3QCynNJB39esJP2Gz9qTcD2SrzhZV1QgITnH8SSYpyc3Mvh+gycpOzKR2jdsBd4mPQbaB8HTLIF+a1NyC2HF8uBMUC5PEudYwzJlEfxxew2EkGLpaIWAeK/tAS3sMjKCVeRZmykacH4nspdwgWVjJuKz/k8t7Gp/lc8mL69EfDA9Ccg+ww+Y4F7ZDvqO1lPKSu73E85VoohER7RXwbzh0k1ItMxxYh3p9OB08btwjMoTWxC/AD7oAWzcyesyEO329xlYoFG8lfwk1oAXshFbuDqGtwxngvuh4u4fz4SGYtcjWGUvgOWrw4w1ftM2QfGcVOmOpl/0j9JmgF2sNAaAeyArjG4IXslFcxz9/70ZehesNcxj5fI8PyYAvBtyM08v3BaNeCxfAJzEp8TVAdYVZ3iMYgZ7+gsVwsvR1CsiI6LgWt+FMYBuvAbBeV3ZB4L+mE7ypMhougs0f3iFGslH+o4a45YzxdD/TZhA1S1wXmoRkZJpJfK7yaUqs6DprDDdCJ3AJkekHLQedDBfrXcA/e0H4C+Ty8+u8Bs5lWCSnznP9zSDzbbv2iuALPkybmwUbAIdD3fwoGwBYw26EkNFqaI6GMPRy+4Z7/cdTA6IY4rd13ouT/PsZkD3sPN0czoq3dpBugb+9stjibeIHIX7/oxjrtUOv/v5S1Qibib2V9RjLdLu1+EnPwQ9+t5TCdYn5/0/plW9eo9J3VrTOX3vAtA2bZ2HZhsbaV/pYvdM4+FvTK2tR7QhkM8vx+f8/9p6rz6CfoDMqmacF0gB4F3ViTmRZxGdiiBut5wwVgpsuOzpWJoL9tOkADaOfagynz4C6YrQnO/NuL6Dg8i9JkEiNnHzeBaan0R9vN6WPHQmQfhCVOrOI+dA7qgL8+7Aezj1TaBGnNR/wFnLF2tkpyVvuFRG2VxUz0k5tsd0pdzZdBL6gD2ilT8N+C2WC2JuqmSp8uCNvDVevwP5VhZ0gOD1XG5Kcz2ROgv4Abgf7HIH6Azo9E20O/rYnOhHaxa+teUFO2kbkvSSG53Yf+SENfiBQ83DkSD6N6ALRLzBJfxgcCq9FvN0FEOZtYGdpUDr2INJGht0QrIhW/g1rk9I2Xok9kBpyGcvgKlXAdVoLdapMmR1sMC5IKMxCQtzvcAt20kxq6jk6vPz1i9gtqG09/SO6d3QAAAABJRU5ErkJggg==">
        </a>
        <div class="gap"></div>
        <a href="javascript:void(0);"
           data-element="{{ $request->get('ne') }}"
           data-hidden="hidden-{{ $request->get('data-ad-client') }}-{{ $request->get('data-ad-slot') }}"
           id="logo-close-btn">
            <img class="logo-close-img"
                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAFo9M/3AAAAAXNSR0IArs4c6QAAARVJREFUOBF9kzGWwjAMRGNKOEdSc6G9xzahoOIe1LkLPe1egW3DfOHxcxIHv6dne2Y0lkTo5nkeOi9dJp9Xuyntt0PmnnnvO6FHJ+g8BgCI3ATgDTAAMwBEysxd7E9K6d9pFqYKwAJhVCDxL5zL4nxRQF4VfXbuKGC0nYiyECimEBS0OmTBwBOntQOkcOr5ixwEFkEqJnbIugtPphdeWq67iOpFPut5hCDbxbCw1d1ucVm8aYFFjJrfubyJgJUFLwSj7mdFTLF+H+F6SU93TJ1mHtHlCmwa7WnKmHipJQLX8osb84XBR7sxAt4kWrsxaFSBln6bJsWgkXj1QL9x/kfs9uhS2VtGgIOCbz4+vjph74w25wxv9VjxEc3jX7MAAAAASUVORK5CYII=">
        </a>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#logo-close-btn').click(function () {
            layer.msg('60分钟内不再展示该广告', {
                shift: 2
            });
            window.setTimeout(() => {
                window.parent.postMessage({
                    action: 'hidden',
                    element: $(this).data('element'),
                    hidden: $(this).data('hidden'),
                }, '*');
            }, 2000);
        });
    });
</script>
</body>
</html>
