<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Page Switching</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #1e1e1e;
            /* Dark gray background */
            color: white;
            overflow: hidden;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        .corner {
            position: absolute;
            padding: 10px 20px;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            transition: transform 0.3s ease, background 0.3s ease;
            z-index: 100;
        }

        .corner:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .top-left {
            top: 20px;
            left: 20px;
        }

        .top-right {
            top: 20px;
            right: 20px;
        }

        .bottom-left {
            bottom: 20px;
            left: 20px;
        }

        .bottom-right {
            bottom: 20px;
            right: 20px;
        }

        .page {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #282828;
            color: white;
            transform: translate(0, 0);
            transition: transform 0.6s ease;
        }

        .page.hidden {
            transform: translate(100%, 0);
            /* Default hidden position */
        }

        .page[data-direction="top"] {
            transform: translate(0, -100%);
        }

        .page[data-direction="bottom"] {
            transform: translate(0, 100%);
        }

        .page[data-direction="left"] {
            transform: translate(-100%, 0);
        }

        .page[data-direction="right"] {
            transform: translate(100%, 0);
        }

        .page.out {
            transition: transform 0.6s ease;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="corner top-left" onclick="switchPage('page1', 'left')">Top Left</div>
        <div class="corner top-right" onclick="switchPage('page2', 'right')">Top Right</div>
        <div class="corner bottom-left" onclick="switchPage('page3', 'bottom')">Bottom Left</div>
        <div class="corner bottom-right" onclick="switchPage('page4', 'top')">Bottom Right</div>
    </div>

    <div id="page1" class="page">Page 1 Content</div>
    <div id="page2" class="page hidden">Page 2 Content</div>
    <div id="page3" class="page hidden">Page 3 Content</div>
    <div id="page4" class="page hidden">Page 4 Content</div>

    <script>
        let currentPage = document.getElementById('page1');

        function switchPage(pageId, direction) {
            const newPage = document.getElementById(pageId);
            if (newPage === currentPage) return; // Avoid redundant actions

            // Move current page out in the chosen direction
            currentPage.classList.remove('hidden');
            currentPage.classList.add('out');
            currentPage.setAttribute('data-direction', direction);

            // Move the new page in
            newPage.classList.remove('hidden', 'out');
            newPage.setAttribute('data-direction', '');

            // Update the current page reference
            currentPage = newPage;
        }
    </script>
</body>

</html>