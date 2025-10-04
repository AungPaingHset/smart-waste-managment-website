
@extends("layouts.app")


@section("content")
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/> --}}
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>

  <style>
    .scanner-container {
      max-width: 1140px;
      margin: 0 auto;
      padding: 0 10px;
    }

    .scan-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 16px;
      margin-bottom: 15px;
      overflow: hidden;
    }


    .camera-feed {
      background: #000;
      border-radius: 12px;
      aspect-ratio: 16/9;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #video, #capturedImage {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 12px;
    }

    .camera-placeholder {
      color: #666;
      font-size: 2.2rem;
    }

    .btn-start,
    .btn-stop,
    .btn-scan {
      border: none;
      border-radius: 10px;
      padding: 8px 20px;
      font-size: 0.9rem;
      font-weight: 600;
    }

    .btn-start {
      background: #28a745;
    }

    .btn-start:hover {
      background: #218838;
    }

    .btn-stop {
      background: #dc3545;
    }

    .btn-stop:hover {
      background: #c82333;
    }

    .btn-scan {
      background: #007bff;
      width: 100%;
      margin-top: 12px;
    }

    .btn-scan:hover:not(:disabled) {
      background: #0056b3;
    }

    .btn-scan:disabled {
      background: #6c757d;
      cursor: not-allowed;
    }

    .scan-results {
      text-align: center;
      min-height: 240px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .scan-placeholder {
      color: #aaa;
      font-size: 0.95rem;
    }

    .result-image {
      width: 100%;
      max-width: 220px;
      border-radius: 12px;
      margin: 0 auto 15px;
    }

    .material-badge {
      display: block;
      width: fit-content;
      margin: 0 auto 12px;
      padding: 6px 16px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .badge-metal {
      background: #6c757d;
      color: white;
    }

    .badge-plastic {
      background: #17a2b8;
      color: white;
    }

    .confidence-bar {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      height: 14px;
      margin: 12px 0;
      overflow: hidden;
    }

    .confidence-fill {
      height: 100%;
      background: linear-gradient(90deg, #28a745, #20c997);
      border-radius: 8px;
      transition: width 0.4s ease;
    }

    .result-details {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 12px;
      padding: 12px;
      margin-top: 15px;
      font-size: 0.9rem;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 6px;
    }

    .btn-reset {
      background: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: white;
      border-radius: 6px;
      padding: 4px 12px;
      font-size: 0.85rem;
    }

    .btn-reset:hover {
      background: rgba(255, 255, 255, 0.3);
      color: white;
    }

    .loading {
      display: none;
    }

    .loading.show {
      display: block;
    }

    .spinner-border {
      color: #007bff;
      width: 1.5rem;
      height: 1.5rem;
    }

    @media (min-width: 992px) {
      .scanner-container .row > .col-lg-6 {
        display: flex;
        flex-direction: column;
      }

      .scanner-container .card.h-100 {
        flex: 1;
      }
    }

    @media (max-width: 576px) {
      .scanner-container {
        padding: 0 5px;
      }

      .card-body {
        padding: 12px;
      }

      .btn-scan {
        font-size: 0.85rem;
        padding: 10px;
      }
    }

    .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #198754;
            margin-bottom: 1.5rem;
        }
        .accordion-button {
            font-weight: 500;
        }
        .caution {
            background-color: linear-gradient(70deg, #0ccb75, rgb(15, 75, 32));
            border-left: 5px solid #28a745;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .accordion-button:not(.collapsed) {
    background-color: white;  
    color: black;              
    box-shadow: none;          
}

  </style>

  <section id="solutions" class="pt-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4">Revolutionizing Waste With E-bin</h2>
                    <p class="lead text-muted">
                        Discover how EcoKyats and E-bin technology can help reduce waste and protect our environment.
                         
                    </p>
                    {{-- @foreach($news as $item)
                    <p>{{ $item->title }}</p>
                    @endforeach --}}
                </div>
            </div>
            
            <!-- E-bin Introduction -->
            <div class="row align-items-center ">
                <div class="col-lg-6">
                    <div class="solution-content">
                        <h3 class="h2 fw-bold mb-4">Introducing E-bin</h3>
                        <p class="lead mb-4">
                            Our smart E-bin system uses AI-powered recognition to automatically sort waste, 
                            making recycling effortless and efficient.
                        </p>
                        <div class="feature-list">
                            <div class="feature-item">
                                <i class="fas fa-robot text-success"></i>
                                <span>AI-powered waste recognition</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-sort text-success"></i>
                                <span>Automatic sorting system</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-chart-line text-success"></i>
                                <span>Real-time analytics</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="ebin-visual">
                        {{-- <i class="fas fa-trash-alt ebin-icon"></i> --}}
                        <img src="/asset/ebin/smart-bin.png" alt="" style="width: 330px; height: 330px;">
                        <div class="ebin-features">
                            <div class="feature-dot" data-bs-toggle="tooltip" title="Camera Scanner">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div class="feature-dot" data-bs-toggle="tooltip" title="AI Processing">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div class="feature-dot" data-bs-toggle="tooltip" title="Auto Sort">
                                <i class="fas fa-arrows-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  

{{-- prices --}}
  {{-- <section> --}}
    <div class="carousel pt-5">
        <div class="list">
          @foreach($news as $item)
              <div class="item">
                <img src="{{ asset('storage/' . $item->image) }}">
                <div class="introduce">
                    <div class="title">NEWS ABOUT POINT GIVING SYSTEM</div>
                    <div class="topic">{{ $item->title }}</div>
                    <div class="des overflow-hidden">
                        {{ $item->content }}
                    </div>
                    <button class="seeMore">SEE MORE &#8599</button>
                </div>
                <div class="detail">
                    <div class="title">{{ $item->title }}</div>
                    <div class="des overflow-hidden">
                         {{ $item->content }}
                    </div>
                     <div class="specifications"> 
                       
                            <p class="fw-bolder mt-2">For one {{ lcfirst($item->title) }}, you will get <span class="text-success">{{ $item->point}}</span> points</p>
                   </div> 
                </div>
            </div>
          @endforeach
        </div>
        <div class="arrows">
            <button id="prev"><</button>
            <button id="next">></button>
            <button id="back">See All  &#8599</button>
        </div>
    </div>
    <!-- logo slider -->
    
     <div class="logos">
      <div class="logos-slide">
        <img src="/asset/logos/ATOM_logo.png" />
        <img src="/asset/logos/The_Mytel_Logo.png" />
        <img src="/asset/logos/Ooredoo_logo.svg.png" />
        <img src="/asset/logos/kbzpay.webp" />
        <img src="/asset/logos/ok$.png" />
        <img src="/asset/logos/ayapay.png" />
        <img src="/asset/logos/wavemoney.jpg" />
        <img src="/asset/logos/capital-logo.png" />
        <img src="/asset/logos/city_mart.png" />
        <img src="/asset/logos/Foodpanda.png" />
        <img src="/asset/logos/grab.png" />
        <img src="/asset/logos/coda_shop.png" />
        {{-- <img src="./logos/menshealth.svg" />
        <img src="./logos/mrbeast.svg" /> --}}
      </div>
    </div>
</section>

<section class="container py-4">
    <div class="row py-4">
    <div class="col-lg-4 col-md-12 d-flex justify-content-center align-items-center ">
            <h2 class="section-title ">How To Use E-bin Correctly</h2>
    </div>

    <div class="accordion col-lg-8 col-md-12" id="cautionAccordion">

        <!-- Plastic Bottle -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingPlastic">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlastic" aria-expanded="false" aria-controls="collapsePlastic">
                   Sort Your Waste Properly
                </button>
            </h2>
            <div id="collapsePlastic" class="accordion-collapse collapse" aria-labelledby="headingPlastic" data-bs-parent="#cautionAccordion">
                <div class="accordion-body">
                    <div class="caution">
                        • Separate plastics, metals, glass, and general waste before disposal.<br>
                        • Check the labels or instructions on the e-bin for correct waste categories.<br>
                        • Avoid mixing recyclable and non-recyclable materials.<br>
                        • Remove food residues from bottles or containers before placing them in the bin.
                    </div>
                </div>
            </div>
        </div>

        <!-- Metal -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingMetal">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMetal" aria-expanded="false" aria-controls="collapseMetal">
                   Follow the Smart Bin Rules
                </button>
            </h2>
            <div id="collapseMetal" class="accordion-collapse collapse" aria-labelledby="headingMetal" data-bs-parent="#cautionAccordion">
                <div class="accordion-body">
                    <div class="caution">
                        • Do not overload the bin; place waste gently inside.<br>
                        • Avoid throwing in oversized or hazardous items (like batteries, chemicals, or sharp objects).<br>
                        • Respect the bin’s weight sensor by not forcing heavy objects inside.<br>
                        • Wait for the lid or system to reset before adding more waste.
                    </div>
                </div>
            </div>
        </div>

        <!-- Glass -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingGlass">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGlass" aria-expanded="false" aria-controls="collapseGlass">
                    Maintain Clean Usage Habits
                </button>
            </h2>
            <div id="collapseGlass" class="accordion-collapse collapse" aria-labelledby="headingGlass" data-bs-parent="#cautionAccordion">
                <div class="accordion-body">
                    <div class="caution">
                        • Wrap wet waste properly to prevent bad odors and leaks.<br>
                        • Close the bin lid after use to avoid pests and contamination.<br>
                        • Report any malfunctions or damage to the management team immediately..<br>
                        • Wash or sanitize your hands after using the bin.
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
</section>

 <section class="app-hero-section py-4"  style="background-image: url('{{ asset('asset/ebin/JustBgGreen.png') }}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="content-wrapper">
                        <h1 class="main-title">DOWNLOAD</h1>
                        <h2 class="subtitle">Our New App</h2>
                        <p class="description">
                            You can get points for disposing of waste correctly  <br class="d-none d-md-block">
                           These points can be accessed and redeemed through our app
                        </p>
                        
                        <div class="download-section">
                            <div class="qr-downloads">
                                <div class="qr-code">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=https://example.com" 
                                         alt="QR Code" class="qr-image">
                                </div>
                                <div class="store-buttons">
                                    <div class="button-row">
                                        <a href="https://www.apple.com/app-store/" class="store-link">
                                            <img src="asset/ebin/download-on-the-app-store.svg" 
                                                 alt="Download on App Store" class="store-button app-store">
                                        </a>
                                        <a href="https://play.google.com/store/" class="store-link">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" 
                                                 alt="Get it on Google Play" class="store-button google-play">
                                        </a>
                                    </div>
                                    {{-- <a href="https://www.website.com" class="website-link">www.website.com</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 col-md-6 d-none d-lg-block">
                    <div class="phone-wrapper">
                        <div class="phone-mockup">
                            <div class="phone-screen">
                                <div class="app-content">
                                    <div class="app-logo">
                                        <!-- <div class="logo-circle">
                                            <div class="logo-leaf"></div>
                                        </div> -->
                                    </div>
                                    <div class="app-title">MOBILE APP</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


  {{-- </section> --}}
  {{-- <div class="container" id="scanner-pane">
    <div class="scanner-container mt-5">
      <div class="row g-3">
        <!-- Camera Feed -->
        <div class="col-12 col-lg-5">
          <div class="scan-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Camera Feed</h5>
                <button id="toggleCamera" class="btn btn-start">
                  <i class="fas fa-camera me-1"></i>Start
                </button>
              </div>

              <div class="camera-feed">
                <div id="cameraPlaceholder" class="camera-placeholder">
                  <i class="fas fa-camera"></i>
                </div>
                <video id="video" style="display: none;" autoplay playsinline></video>
                <canvas id="canvas" style="display: none;"></canvas>
              </div>

              <button id="scanBtn" class="btn btn-scan mt-3" disabled>
                <i class="fas fa-scan me-1"></i>Scan
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-2">

        </div>
        <!-- Scan Results -->
        <div class="col-12 col-lg-5">
          <div class="scan-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Scan Results</h5>
                <button id="resetBtn" class="btn btn-reset" style="display: none;">Reset</button>
              </div>

              <div id="scanResults" class="scan-results">
                <div id="scanPlaceholder" class="scan-placeholder">
                  <div class="mb-2">
                    <i class="fas fa-crosshairs" style="font-size: 2rem; opacity: 0.3;"></i>
                  </div>
                  <p>Capture an image to scan</p>
                </div>

                <div id="loadingIndicator" class="loading">
                  <div class="spinner-border mb-2" role="status"></div>
                  <p>Analyzing...</p>
                </div>

                <div id="resultContent" style="display: none;">
                  <img id="resultImage" class="result-image" />
                  <div id="materialBadge" class="material-badge"></div>
                  <div id="confidenceText" class="fw-semibold mb-1"></div>
                  <div class="confidence-bar">
                    <div id="confidenceFill" class="confidence-fill" style="width: 0%;"></div>
                  </div>
                  <div id="materialDescription" class="mb-2 small"></div>
                  <div class="result-details">
                    <div class="detail-row">
                      <span>Material</span>
                      <span id="materialType">-</span>
                    </div>
                    <div class="detail-row">
                      <span>Confidence</span>
                      <span id="confidenceValue">-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center mt-3 small text-white-50">
        {{-- <p class="mb-0">Point your camera at an object and tap Scan</p> --}}
      {{-- </div>
    </div> --}}
  {{-- </div> --}} 

  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
  <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-leaf me-2"></i>EcoKyats
                    </h5>
                    <p class="text-light">
                        Leading the way in smart waste management and environmental protection 
                        through innovative E-bin technology.
                    </p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 ">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/')}}" class="text-light text-decoration-none">Home</a></li>
                       
                        <li><a href="{{ url('/ebin')}}" class="text-light text-decoration-none">Ebin</a></li>
                         <li><a href="{{ url('/articles')}}" class="text-light text-decoration-none">Our Community</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">E-bin Features</h6>
                    <ul class="list-unstyled">
                        <li class="text-light">AI Material Recognition</li>
                        <li class="text-light">Automatic Sorting</li>
                        <li class="text-light">Real-time Analytics</li>
                        <li class="text-light">Mobile Integration</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold mb-3">Contact Info</h6>
                    <div class="contact-info">
                        <p class="text-light mb-2">
                            <i class="fas fa-envelope me-2"></i>info@ecokyats.com
                        </p>
                        <p class="text-light mb-2">
                            <i class="fas fa-phone me-2"></i>+95 9784597686
                        </p>
                        <p class="text-light">
                            <i class="fas fa-map-marker-alt me-2"></i>Green Tech Center, Yangon
                        </p>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2025 EcoKyats. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-light mb-0">Making the world cleaner, one scan at a time.</p>
                </div>
            </div>
        </div>
    </footer>
   


  
    
    <script>
           


        // Teachable Machine model URL
        // const teachableMachineBaseURL = "https://teachablemachine.withgoogle.com/models/8RUgMrbys/";
         const teachableMachineBaseURL = "https://teachablemachine.withgoogle.com/models/bx82WJWdH/";
        
        let model, webcam, isWebcamRunning = false;
        
        // DOM elements
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const toggleCameraBtn = document.getElementById('toggleCamera');
        const scanBtn = document.getElementById('scanBtn');
        const resetBtn = document.getElementById('resetBtn');
        const cameraPlaceholder = document.getElementById('cameraPlaceholder');
        const scanPlaceholder = document.getElementById('scanPlaceholder');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const resultContent = document.getElementById('resultContent');
        const resultImage = document.getElementById('resultImage');
        const materialBadge = document.getElementById('materialBadge');
        const confidenceText = document.getElementById('confidenceText');
        const confidenceFill = document.getElementById('confidenceFill');
        const materialDescription = document.getElementById('materialDescription');
        const materialType = document.getElementById('materialType');
        const confidenceValue = document.getElementById('confidenceValue');

        // Load the Teachable Machine model
        async function loadModel() {
            try {
                const modelURL = teachableMachineBaseURL + "model.json";
                const metadataURL = teachableMachineBaseURL + "metadata.json";
                model = await tmImage.load(modelURL, metadataURL);
                console.log("Model loaded successfully");
            } catch (error) {
                console.error("Error loading model:", error);
                alert("Failed to load the AI model. Please refresh the page and try again.");
            }
        }

        // Initialize camera
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 480 },
                        height: { ideal: 480 }
                    } 
                });
                
                video.srcObject = stream;
                video.style.display = 'block';
                cameraPlaceholder.style.display = 'none';
                
                isWebcamRunning = true;
                toggleCameraBtn.innerHTML = '<i class="fas fa-stop me-2"></i>Stop Camera';
                toggleCameraBtn.className = 'btn btn-stop';
                scanBtn.disabled = false;
                
            } catch (error) {
                console.error("Error accessing camera:", error);
                alert("Unable to access camera. Please make sure you have granted camera permissions.");
            }
        }

        // Stop camera
        function stopCamera() {
            if (video.srcObject) {
                const tracks = video.srcObject.getTracks();
                tracks.forEach(track => track.stop());
                video.srcObject = null;
            }
            
            video.style.display = 'none';
            cameraPlaceholder.style.display = 'flex';
            
            isWebcamRunning = false;
            toggleCameraBtn.innerHTML = '<i class="fas fa-camera me-2"></i>Start Camera';
            toggleCameraBtn.className = 'btn btn-start';
            scanBtn.disabled = true;
        }

        // Capture and analyze image
        async function scanMaterial() {
            if (!model) {
                alert("AI model is still loading. Please wait a moment and try again.");
                return;
            }

            // Show loading
            scanPlaceholder.style.display = 'none';
            resultContent.style.display = 'none';
            loadingIndicator.classList.add('show');
            
            try {
                // Capture image from video
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0);
                
                // Convert to image data URL
                const imageDataURL = canvas.toDataURL('image/png');
                
                // Create image element for prediction
                const img = new Image();
                img.onload = async () => {
                    try {
                        // Make prediction
                        const predictions = await model.predict(img);
                        
                        // Find the prediction with highest confidence
                        let maxPrediction = predictions[0];
                        for (let i = 1; i < predictions.length; i++) {
                            if (predictions[i].probability > maxPrediction.probability) {
                                maxPrediction = predictions[i];
                            }
                        }
                        
                        // Display results
                        displayResults(imageDataURL, maxPrediction);
                        
                    } catch (error) {
                        console.error("Prediction error:", error);
                        alert("Error analyzing the image. Please try again.");
                        loadingIndicator.classList.remove('show');
                        scanPlaceholder.style.display = 'block';
                    }
                };
                img.src = imageDataURL;
                
            } catch (error) {
                console.error("Capture error:", error);
                alert("Error capturing image. Please try again.");
                loadingIndicator.classList.remove('show');
                scanPlaceholder.style.display = 'block';
            }
        }

        // Display prediction results
        function displayResults(imageDataURL, prediction) {
            // Hide loading
            loadingIndicator.classList.remove('show');
            
            // Show result content
            resultContent.style.display = 'block';
            resetBtn.style.display = 'block';
            
            // Set captured image
            resultImage.src = imageDataURL;
            
            // Determine material type
            const material = prediction.className.toLowerCase();
            const confidence = Math.round(prediction.probability * 100);
            
            // Set material badge
            materialBadge.textContent = material.toUpperCase();
            materialBadge.className = `material-badge badge-${material}`;
            
            // Set confidence
            confidenceText.textContent = `${confidence}% confident`;
            confidenceFill.style.width = `${confidence}%`;
            
            // Set material description
            const descriptions = {
                'metal': 'Metal object detected with characteristic shine',
                'plastic': 'Plastic object detected with polymer characteristics'
            };
            materialDescription.textContent = descriptions[material] || 'Material detected';
            
            // Set detail values
            materialType.textContent = material.charAt(0).toUpperCase() + material.slice(1);
            confidenceValue.textContent = `${confidence}%`;
            
            // Update confidence bar color based on confidence level
            if (confidence >= 80) {
                confidenceFill.style.background = 'linear-gradient(90deg, #28a745, #20c997)';
            } else if (confidence >= 60) {
                confidenceFill.style.background = 'linear-gradient(90deg, #ffc107, #fd7e14)';
            } else {
                confidenceFill.style.background = 'linear-gradient(90deg, #dc3545, #e83e8c)';
            }
        }

        // Reset scan results
        function resetResults() {
            resultContent.style.display = 'none';
            resetBtn.style.display = 'none';
            scanPlaceholder.style.display = 'block';
            loadingIndicator.classList.remove('show');
        }

        // Event listeners
        toggleCameraBtn.addEventListener('click', () => {
            if (isWebcamRunning) {
                stopCamera();
            } else {
                startCamera();
            }
        });

        scanBtn.addEventListener('click', scanMaterial);
        resetBtn.addEventListener('click', resetResults);

        // Initialize the application
        async function init() {
            console.log("Initializing Metal/Plastic Scanner...");
            await loadModel();
            console.log("Application ready!");
        }

        // Start the application
        init();
    </script>
@endsection
