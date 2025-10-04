// EcoKyats Website JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initNavigation();
    initScanner();
    initFeedback();
    loadFeedbackData();
    
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Navigation functionality
function initNavigation() {
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Update active nav link on scroll
    window.addEventListener('scroll', updateActiveNavLink);
}

function updateActiveNavLink() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        if (window.pageYOffset >= sectionTop) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
}

// Scanner functionality
function initScanner() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const previewArea = document.getElementById('previewArea');
    const previewImage = document.getElementById('previewImage');
    const scanBtn = document.getElementById('scanBtn');
    const clearBtn = document.getElementById('clearBtn');
    const webcam = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const startWebcamBtn = document.getElementById('startWebcam');
    const captureBtn = document.getElementById('captureBtn');
    const stopWebcamBtn = document.getElementById('stopWebcam');
    
    let stream = null;
    let currentImageFile = null;

    // Tab switching
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.getAttribute('data-tab');
            
            // Update active tab button
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Update active tab content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `${tabId}-tab`) {
                    content.classList.add('active');
                }
            });
            
            // Stop webcam if switching away from webcam tab
            if (tabId !== 'webcam' && stream) {
                stopWebcam();
            }
        });
    });

    // Upload area functionality
    uploadArea.addEventListener('click', () => imageInput.click());
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            handleImageUpload(files[0]);
        }
    });
    
    imageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleImageUpload(e.target.files[0]);
        }
    });

    // Webcam functionality
    startWebcamBtn.addEventListener('click', startWebcam);
    captureBtn.addEventListener('click', captureImage);
    stopWebcamBtn.addEventListener('click', stopWebcam);

    // Scanner controls
    scanBtn.addEventListener('click', scanImage);
    clearBtn.addEventListener('click', clearPreview);

    function handleImageUpload(file) {
        currentImageFile = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewArea.style.display = 'block';
            hideResults();
        };
        reader.readAsDataURL(file);
    }

    async function startWebcam() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { width: 640, height: 480 } 
            });
            webcam.srcObject = stream;
            
            startWebcamBtn.style.display = 'none';
            captureBtn.style.display = 'inline-block';
            stopWebcamBtn.style.display = 'inline-block';
        } catch (error) {
            console.error('Error accessing webcam:', error);
            showAlert('Unable to access webcam. Please check permissions.', 'danger');
        }
    }

    function captureImage() {
        const context = canvas.getContext('2d');
        canvas.width = webcam.videoWidth;
        canvas.height = webcam.videoHeight;
        context.drawImage(webcam, 0, 0);
        
        canvas.toBlob((blob) => {
            currentImageFile = new File([blob], 'webcam-capture.jpg', { type: 'image/jpeg' });
            previewImage.src = canvas.toDataURL();
            previewArea.style.display = 'block';
            hideResults();
        }, 'image/jpeg', 0.8);
    }

    function stopWebcam() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
            webcam.srcObject = null;
            
            startWebcamBtn.style.display = 'inline-block';
            captureBtn.style.display = 'none';
            stopWebcamBtn.style.display = 'none';
        }
    }

    function clearPreview() {
        previewArea.style.display = 'none';
        currentImageFile = null;
        hideResults();
        imageInput.value = '';
    }

    async function scanImage() {
        if (!currentImageFile) {
            showAlert('Please select an image first.', 'warning');
            return;
        }

        showScanning();

        const formData = new FormData();
        formData.append('image', currentImageFile);

        try {
            const response = await fetch('/api/scan', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            
            if (response.ok) {
                showResults(result);
            } else {
                throw new Error(result.error || 'Scanning failed');
            }
        } catch (error) {
            console.error('Scan error:', error);
            showAlert('Scanning failed. Please try again.', 'danger');
            hideScanning();
        }
    }

    function showScanning() {
        document.getElementById('scanningLoader').style.display = 'block';
        hideResults();
    }

    function hideScanning() {
        document.getElementById('scanningLoader').style.display = 'none';
    }

    function showResults(result) {
        hideScanning();
        
        const resultsDiv = document.getElementById('scanResults');
        const materialIcon = document.getElementById('materialIcon');
        const materialType = document.getElementById('materialType');
        const materialMessage = document.getElementById('materialMessage');
        const confidenceText = document.getElementById('confidenceText');
        const confidenceBar = document.getElementById('confidenceBar');
        const recyclableStatus = document.getElementById('recyclableStatus');
        const instructionsText = document.getElementById('instructionsText');

        // Update material info
        materialType.textContent = result.material.charAt(0).toUpperCase() + result.material.slice(1);
        materialMessage.textContent = result.message;
        
        // Update confidence
        confidenceText.textContent = `${result.confidence}%`;
        confidenceBar.style.width = `${result.confidence}%`;
        
        // Update material icon
        materialIcon.className = `material-icon ${result.material}`;
        materialIcon.innerHTML = getMaterialIcon(result.material);
        
        // Update recyclable status
        recyclableStatus.className = `recyclable-status ${result.recyclable ? 'recyclable' : 'non-recyclable'}`;
        recyclableStatus.innerHTML = `
            <i class="fas fa-${result.recyclable ? 'recycle' : 'times-circle'}"></i>
            <span>${result.recyclable ? 'Recyclable' : 'Non-Recyclable'}</span>
        `;
        
        // Update disposal instructions
        instructionsText.textContent = getDisposalInstructions(result.material, result.recyclable);
        
        resultsDiv.style.display = 'block';
        resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideResults() {
        document.getElementById('scanResults').style.display = 'none';
    }

    function getMaterialIcon(material) {
        const icons = {
            plastic: '<i class="fas fa-bottle-water"></i>',
            metal: '<i class="fas fa-cog"></i>',
            glass: '<i class="fas fa-wine-bottle"></i>',
            paper: '<i class="fas fa-file-alt"></i>',
            organic: '<i class="fas fa-leaf"></i>'
        };
        return icons[material] || '<i class="fas fa-question"></i>';
    }

    function getDisposalInstructions(material, recyclable) {
        const instructions = {
            plastic: recyclable ? 
                'Clean the plastic item and place it in your recycling bin. Remove any caps or labels if possible.' :
                'This type of plastic cannot be recycled. Dispose of it in regular trash or look for specialized disposal programs.',
            metal: 'Clean the metal item and place it in your recycling bin. Metals are highly recyclable and valuable.',
            glass: 'Rinse the glass item and place it in your recycling bin. Remove any caps or lids first.',
            paper: 'Ensure the paper is clean and dry, then place it in your recycling bin. Remove any plastic coatings.',
            organic: 'Compost this organic material in your home compost bin or municipal composting program.'
        };
        return instructions[material] || 'Please consult your local waste management guidelines for proper disposal.';
    }
}

// Feedback functionality
function initFeedback() {
    const feedbackForm = document.getElementById('feedbackForm');
    const ratingStars = document.querySelectorAll('#ratingStars i');
    const userRating = document.getElementById('userRating');
    
    // Rating stars functionality
    ratingStars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1;
            userRating.value = rating;
            updateStarDisplay(rating);
        });
        
        star.addEventListener('mouseenter', () => {
            updateStarDisplay(index + 1);
        });
    });
    
    document.getElementById('ratingStars').addEventListener('mouseleave', () => {
        updateStarDisplay(parseInt(userRating.value));
    });
    
    function updateStarDisplay(rating) {
        ratingStars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }
    
    // Initialize with 5 stars
    updateStarDisplay(5);
    
    // Form submission
    feedbackForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = {
            name: document.getElementById('userName').value,
            email: document.getElementById('userEmail').value,
            rating: parseInt(userRating.value),
            message: document.getElementById('userMessage').value
        };
        
        try {
            const response = await fetch('/api/feedback', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (response.ok) {
                showAlert(result.message, 'success');
                feedbackForm.reset();
                updateStarDisplay(5);
                userRating.value = 5;
                loadFeedbackData(); // Refresh feedback display
            } else {
                throw new Error(result.error || 'Failed to submit feedback');
            }
        } catch (error) {
            console.error('Feedback submission error:', error);
            showAlert('Failed to submit feedback. Please try again.', 'danger');
        }
    });
}

async function loadFeedbackData() {
    try {
        const response = await fetch('/api/feedback');
        const feedbackData = await response.json();
        
        const feedbackList = document.getElementById('feedbackList');
        feedbackList.innerHTML = '';
        
        feedbackData.forEach(feedback => {
            const feedbackItem = createFeedbackItem(feedback);
            feedbackList.appendChild(feedbackItem);
        });
    } catch (error) {
        console.error('Error loading feedback:', error);
    }
}

function createFeedbackItem(feedback) {
    const item = document.createElement('div');
    item.className = 'feedback-item fade-in';
    
    const stars = '★'.repeat(feedback.rating) + '☆'.repeat(5 - feedback.rating);
    
    item.innerHTML = `
        <div class="feedback-header">
            <span class="feedback-name">${feedback.name}</span>
            <span class="feedback-date">${formatDate(feedback.date)}</span>
        </div>
        <div class="feedback-rating">
            ${stars}
        </div>
        <p class="feedback-message">${feedback.message}</p>
    `;
    
    return item;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

function showAlert(message, type) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} fade-in`;
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            ${message}
        </div>
    `;
    
    // Insert alert at the top of the page
    document.body.insertBefore(alert, document.body.firstChild);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
        }
    });
}, observerOptions);

// Observe elements for animation
document.addEventListener('DOMContentLoaded', () => {
    const animateElements = document.querySelectorAll('.issue-card, .solution-card, .tip-card');
    animateElements.forEach(el => observer.observe(el));
});