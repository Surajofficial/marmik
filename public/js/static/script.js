const video = document.getElementById('video')

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/js/static/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/js/static/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/js/static/models'),
  faceapi.nets.faceExpressionNet.loadFromUri('/js/static/models')
]).then(startVideo)

function startVideo() {
  navigator.getUserMedia({
    video: {}
  },
    stream => video.srcObject = stream,
    err => console.error(err)
  )
}

video.addEventListener('play', () => {
  // const canvas = faceapi.createCanvasFromMedia(video)
  // console.log(canvas)
  // document.body.append(canvas)
  const displaySize = {
    width: video.width + 500,
    height: video.height + 300
  }
  // faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    // canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    // faceapi.draw.drawDetections(canvas, resizedDetections)

    if (resizedDetections.length > 0) {
      const score = resizedDetections[0].alignedRect._score;
      const remDiv = document.getElementById('btn-1');
      
      if (remDiv) { 
        if (score > 0.90) {
          remDiv.innerHTML = 'Position: Good';
          remDiv.classList.remove("btn-danger", "btn-warning");
          remDiv.classList.add("btn-success");
        } else if (score >= 0.60) {
          remDiv.innerHTML = 'Position: OK';
          remDiv.classList.remove("btn-danger", "btn-success");
          remDiv.classList.add("btn-warning");
        } else {
          remDiv.innerHTML = 'Position: Not Good';
          remDiv.classList.remove("btn-success", "btn-warning");
          remDiv.classList.add("btn-danger");
        }
      }
    }
    // faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    // faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
  }, 100)
})
