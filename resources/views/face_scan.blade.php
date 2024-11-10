<!-- resources/views/face_scan.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Scan Diet Recommendation</title>
</head>
<body>
    <h1>Scan Your Face for Diet Recommendation</h1>
    <video id="video" width="320" height="240" autoplay></video>
    <button id="capture">Scan Face</button>
    <p id="result"></p>

    <script>
        const video = document.getElementById('video');
        const result = document.getElementById('result');
        const captureButton = document.getElementById('capture');

        // Access the device camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing camera: ", err);
            });

        captureButton.addEventListener('click', () => {
            // Stop the video stream after a short delay
            setTimeout(() => {
                const tracks = video.srcObject.getTracks();
                tracks.forEach(track => track.stop());
                video.srcObject = null;

                // Fetch random diet recommendation from the server
                fetch('/diet-recommendation')
                    .then(response => response.json())
                    .then(data => {
                        result.textContent = `Your recommended diet for skin care: ${data.diet}`;
                    });
            }, 3000); // 3 seconds delay
        });
    </script>
</body>
</html>
