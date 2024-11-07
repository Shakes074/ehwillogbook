<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <!-- Link to your global CSS file -->
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styling for the PDF viewer */
        .pdf-viewer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 2rem;
        }
        .pdf-canvas {
            border: 1px solid #ccc;
            margin: 1rem 0;
        }
        .controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
        }
        .page-number {
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="pdf-viewer-container">
    <!-- PDF Canvas where pages will be rendered -->
    <canvas id="pdfCanvas" class="pdf-canvas"></canvas>

    <!-- Controls for PDF navigation -->
    <div class="controls">
        <button onclick="prevPage()">Previous</button>
        <span class="page-number">Page <span id="pageNumber">1</span> of <span id="pageCount">--</span></span>
        <button onclick="nextPage()">Next</button>
    </div>
</div>

<!-- PDF.js Library from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    // URL to your PDF file (replace 'sample.pdf' with the path to your PDF)
    const pdfUrl = 'sample.pdf';

    let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1.5,
        canvas = document.getElementById('pdfCanvas'),
        ctx = canvas.getContext('2d');

    // Load the PDF document
    pdfjsLib.getDocument(pdfUrl).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        document.getElementById('pageCount').textContent = pdfDoc.numPages;
        renderPage(pageNum);
    });

    // Render a specific page
    function renderPage(num) {
        pageRendering = true;
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            const renderTask = page.render(renderContext);

            renderTask.promise.then(() => {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        document.getElementById('pageNumber').textContent = num;
    }

    // Queue rendering for a page if a page is already being rendered
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    // Display the previous page
    function prevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }

    // Display the next page
    function nextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }
</script>
</body>
</html>
