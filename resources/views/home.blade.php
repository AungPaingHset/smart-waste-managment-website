{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco-Friendly Articles Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
   
    <style>
        /* Custom Eco-Friendly Theme */
:root {
    --eco-primary: #28a745;
    --eco-primary-dark: #1e7e34;
    --eco-secondary: #20c997;
    --eco-light: rgba(40, 167, 69, 0.1);
    --eco-border: rgba(40, 167, 69, 0.2);
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

/* Section Heading */
.section-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--eco-primary);
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Add Article Button */
.add-article-btn {
    background: linear-gradient(135deg, var(--eco-primary) 0%, var(--eco-secondary) 100%);
    border: none;
    padding: 12px 24px;
    font-size: 1.1rem;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.add-article-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, var(--eco-primary-dark) 0%, var(--eco-primary) 100%);
}

/* Article Cards */
.article-card {
    border-left: 5px solid var(--eco-border);
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.article-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 35px rgba(40, 167, 69, 0.15);
    border-left-color: var(--eco-primary);
}

.article-body {
    color: #333;
    line-height: 1.7;
    font-size: 0.95rem;
}

.meta-info {
    font-size: 0.875rem;
    color: #6c757d;
}

.meta-info b {
    color: var(--eco-primary);
    font-weight: 600;
}

.badge-comment {
    background: var(--eco-light);
    color: var(--eco-primary);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    border: 1px solid var(--eco-border);
    font-weight: 500;
}

.card-link {
    color: var(--eco-primary);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
}

.card-link:hover {
    color: var(--eco-primary-dark);
    transform: translateX(5px);
}

/* Pagination Styling */
.pagination .page-link {
    color: var(--eco-primary);
    border-color: var(--eco-border);
    transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
    background-color: var(--eco-primary);
    border-color: var(--eco-primary);
}

.pagination .page-link:hover {
    background-color: var(--eco-light);
    border-color: var(--eco-primary);
    color: var(--eco-primary-dark);
}

/* Flash Modal Styles */
.flash-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    pointer-events: none;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 80px;
}

.flash-modal.show {
    pointer-events: auto;
}

.flash-modal-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    max-width: 500px;
    width: 90%;
    margin: 0 20px;
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
}

.flash-modal.show .flash-modal-content {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.flash-modal-header {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.flash-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.flash-message {
    flex: 1;
    font-weight: 500;
    color: #333;
    line-height: 1.4;
}

.flash-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #999;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.flash-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #666;
}

.flash-progress {
    height: 4px;
    background: rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.flash-progress-bar {
    height: 100%;
    width: 100%;
    transform: translateX(-100%);
    transition: transform 3s linear;
}

/* Flash message type styles */
.flash-modal.success .flash-icon {
    color: #28a745;
}

.flash-modal.success .flash-progress-bar {
    background: #28a745;
}

.flash-modal.success .flash-modal-content {
    border-left: 4px solid #28a745;
}

.flash-modal.info .flash-icon {
    color: #17a2b8;
}

.flash-modal.info .flash-progress-bar {
    background: #17a2b8;
}

.flash-modal.info .flash-modal-content {
    border-left: 4px solid #17a2b8;
}

.flash-modal.warning .flash-icon {
    color: #ffc107;
}

.flash-modal.warning .flash-progress-bar {
    background: #ffc107;
}

.flash-modal.warning .flash-modal-content {
    border-left: 4px solid #ffc107;
}

.flash-modal.error .flash-icon {
    color: #dc3545;
}

.flash-modal.error .flash-progress-bar {
    background: #dc3545;
}

.flash-modal.error .flash-modal-content {
    border-left: 4px solid #dc3545;
}

/* Demo buttons styling */
.demo-buttons h6 {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .section-heading {
        font-size: 2rem;
    }
    
    .flash-modal {
        padding-top: 40px;
    }
    
    .flash-modal-content {
        margin: 0 10px;
    }
    
    .article-card:hover {
        transform: translateY(-2px) scale(1.01);
    }
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: var(--eco-primary);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--eco-primary-dark);
}
    </style>
</head>
<body>
    <!-- Flash Message Modal -->
    <div id="flashModal" class="flash-modal">
        <div class="flash-modal-content">
            <div class="flash-modal-header">
                <i id="flashIcon" class="bi bi-info-circle flash-icon"></i>
                <span id="flashMessage" class="flash-message"></span>
                <button type="button" class="flash-close" onclick="closeFlashModal()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div id="flashProgress" class="flash-progress">
                <div id="flashProgressBar" class="flash-progress-bar"></div>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 1200px;">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <!-- Section Heading -->
                <h1 class="section-heading">
                    Join Us in Building a Greener Future by Sharing Your Valuable Feedback with Our Eco-Conscious Community
                </h1>

                <!-- Add Article CTA -->
                <a href="#" class="btn btn-success mb-4 fw-semibold shadow-sm add-article-btn" onclick="showFlashMessage('success', 'Article creation feature coming soon!')">
                    <i class="bi bi-plus-circle me-2"></i> Add Article
                </a>

                <!-- Demo Flash Message Buttons -->
                <div class="demo-buttons mt-4">
                    <h6 class="text-muted mb-3">Demo Flash Messages:</h6>
                    <button class="btn btn-outline-success btn-sm me-2 mb-2" onclick="showFlashMessage('success', 'Article posted successfully!')">Success</button>
                    <button class="btn btn-outline-info btn-sm me-2 mb-2" onclick="showFlashMessage('info', 'Welcome to our eco-friendly community!')">Info</button>
                    <button class="btn btn-outline-warning btn-sm me-2 mb-2" onclick="showFlashMessage('warning', 'Please fill all required fields.')">Warning</button>
                    <button class="btn btn-outline-danger btn-sm me-2 mb-2" onclick="showFlashMessage('error', 'An error occurred while saving.')">Error</button>
                </div>
            </div>
            
            <div class="col-lg-6">
                <!-- Pagination -->
                <div class="d-flex justify-content-center mb-4">
                    <nav aria-label="Article pagination">
                        <ul class="pagination pagination-sm">
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Articles List -->
                <div id="articlesList">
                    <!-- Articles will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Show welcome message on page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                showFlashMessage('info', 'Welcome to our eco-friendly community! Share your green ideas and connect with like-minded individuals.');
            }, 1000);
        });
        // Sample Articles Data
const articles = [
    {
        id: 1,
        user: { name: "Emma Green" },
        created_at: "2024-01-15",
        comments: 2,
        body: "Starting your journey towards sustainable living doesn't have to be overwhelming. Here are some simple steps you can take today to reduce your environmental impact. From switching to reusable bags to composting kitchen scraps, every small action contributes to a healthier planet."
    },
    {
        id: 2,
        user: { name: "John Eco" },
        created_at: "2024-01-14",
        comments: 3,
        body: "Fast fashion has become one of the most polluting industries in the world. The constant cycle of producing cheap, disposable clothing is devastating our environment through water pollution, textile waste, and carbon emissions."
    },
    {
        id: 3,
        user: { name: "Sarah Nature" },
        created_at: "2024-01-13",
        comments: 1,
        body: "Transitioning to renewable energy at home is easier than ever before. Solar panels, wind turbines, and energy-efficient appliances can significantly reduce your carbon footprint while saving money on utility bills."
    },
    {
        id: 4,
        user: { name: "Mike Earth" },
        created_at: "2024-01-12",
        comments: 2,
        body: "Eliminating plastic from your daily life might seem impossible, but with the right strategies and alternatives, it's entirely achievable. From plastic-free personal care products to zero-waste shopping habits."
    },
    {
        id: 5,
        user: { name: "Lisa Solar" },
        created_at: "2024-01-11",
        comments: 1,
        body: "You don't need a large backyard to grow your own food. Urban gardening techniques like vertical gardens, container gardening, and hydroponics make it possible to cultivate fresh produce in apartments."
    },
    {
        id: 6,
        user: { name: "David Wind" },
        created_at: "2024-01-10",
        comments: 4,
        body: "Electric vehicles are revolutionizing transportation by offering a cleaner alternative to traditional gas-powered cars. With zero direct emissions, lower operating costs, and improving charging infrastructure."
    }
];

// Flash Message Functions
let flashTimeout;

function showFlashMessage(type, message) {
    const modal = document.getElementById('flashModal');
    const icon = document.getElementById('flashIcon');
    const messageEl = document.getElementById('flashMessage');
    const progressBar = document.getElementById('flashProgressBar');
    
    // Clear any existing timeout
    if (flashTimeout) {
        clearTimeout(flashTimeout);
    }
    
    // Set content
    messageEl.textContent = message;
    
    // Set icon based on type
    const icons = {
        success: 'bi-check-circle-fill',
        info: 'bi-info-circle-fill',
        warning: 'bi-exclamation-triangle-fill',
        error: 'bi-x-circle-fill'
    };
    
    // Reset classes
    modal.className = `flash-modal show ${type}`;
    icon.className = `flash-icon ${icons[type] || icons.info}`;
    
    // Reset progress bar
    progressBar.style.transform = 'translateX(-100%)';
    
    // Show modal
    setTimeout(() => {
        progressBar.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto-hide after 3 seconds
    flashTimeout = setTimeout(() => {
        closeFlashModal();
    }, 3000);
}

function closeFlashModal() {
    const modal = document.getElementById('flashModal');
    modal.classList.remove('show');
    
    if (flashTimeout) {
        clearTimeout(flashTimeout);
    }
}

// Format date function
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

// Truncate text function
function truncateText(text, limit) {
    if (text.length <= limit) return text;
    return text.substring(0, limit) + '...';
}

// Render articles function
function renderArticles() {
    const articlesList = document.getElementById('articlesList');
    
    const articlesHTML = articles.map(article => `
        <div class="card mb-4 article-card shadow-sm">
            <div class="card-body">
                <!-- Meta Info -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="meta-info">
                        <b>${article.user.name}</b> &middot;
                        <small>${formatDate(article.created_at)}</small>
                    </div>
                    <span class="badge-comment">
                        💬 ${article.comments} Comments
                    </span>
                </div>

                <!-- Article Body -->
                <div class="article-body mb-3">
                    ${truncateText(article.body, 120)}
                </div>

                <!-- Link to Details -->
                <a href="#" class="card-link" onclick="showFlashMessage('info', 'Article detail view coming soon!')">
                    → View Detail
                </a>
            </div>
        </div>
    `).join('');
    
    articlesList.innerHTML = articlesHTML;
}

// Initialize the app
document.addEventListener('DOMContentLoaded', function() {
    renderArticles();
    
    // Close modal when clicking outside
    document.getElementById('flashModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFlashModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFlashModal();
        }
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
    </script>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Laravel App</title>
    <!-- Your existing Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Add the flash modal CSS -->
    <style>
        /* Your existing styles here */
        
        /* ADD THE FLASH MODAL CSS FROM flash-modal-styles.css HERE */
        .flash-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            pointer-events: none;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 80px;
        }

        .flash-modal.show {
            pointer-events: auto;
        }

        .flash-modal-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 90%;
            margin: 0 20px;
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }

        .flash-modal.show .flash-modal-content {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .flash-modal-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .flash-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .flash-message {
            flex: 1;
            font-weight: 500;
            color: #333;
            line-height: 1.4;
        }

        .flash-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #999;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .flash-close:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #666;
        }

        .flash-progress {
            height: 4px;
            background: rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .flash-progress-bar {
            height: 100%;
            width: 100%;
            transform: translateX(-100%);
            transition: transform 3s linear;
        }

        /* Flash message type styles */
        .flash-modal.info .flash-icon {
            color: #17a2b8;
        }

        .flash-modal.info .flash-progress-bar {
            background: #17a2b8;
        }

        .flash-modal.info .flash-modal-content {
            border-left: 4px solid #17a2b8;
        }

        /* Add other styles from flash-modal-styles.css */
    </style>
</head>
<body>
    <!-- Your existing Laravel Blade content -->
    <div class="container py-5" style="max-width: 1200px;">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <p class="section-heading">
                    Join Us in Building a Greener Future by Sharing Your Valuable Feedback with Our Eco-Conscious Community
                </p>
                <a href="{{ url('/articles/add') }}" class="btn btn-success mb-4 fw-semibold shadow-sm add-article-btn">
                    <i class="bi bi-plus-circle me-1"></i> Add Article
                </a>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-center mb-4">
                    {{ $articles->links() }}
                </div>
                
                <!-- Flash Message - This will be hidden and converted to modal -->
                @if (session('info'))
                    <div class="alert alert-info shadow-sm">
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Your existing article loop -->
                @foreach ($articles as $article)
                    <div class="card mb-4 article-card shadow-sm" id="glass-btn">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="meta-info">
                                    <b>{{ $article->user->name }}</b> &middot;
                                    <small>{{ $article->created_at->format('M d, Y') }}</small>
                                </div>
                                <span class="badge-comment">
                                    🗨️ {{ count($article->comments) }} Comments
                                </span>
                            </div>
                            <div class="article-body mb-3">
                                {{ \Illuminate\Support\Str::limit($article->body, 120) }}
                            </div>
                            <a href="{{ url("/articles/detail/$article->id") }}" class="card-link">
                                → View Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Your existing Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Add the flash modal JavaScript -->
    <script>
        // ADD THE FLASH MODAL JAVASCRIPT FROM flash-modal-script.js HERE
        let flashTimeout;

        function showFlashMessage(type, message) {
            const existingModal = document.getElementById('flashModal');
            if (existingModal) {
                existingModal.remove();
            }

            const modalHTML = `
                <div id="flashModal" class="flash-modal">
                    <div class="flash-modal-content">
                        <div class="flash-modal-header">
                            <i id="flashIcon" class="flash-icon"></i>
                            <span id="flashMessage" class="flash-message"></span>
                            <button type="button" class="flash-close" onclick="closeFlashModal()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div id="flashProgress" class="flash-progress">
                            <div id="flashProgressBar" class="flash-progress-bar"></div>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHTML);

            const modal = document.getElementById('flashModal');
            const icon = document.getElementById('flashIcon');
            const messageEl = document.getElementById('flashMessage');
            const progressBar = document.getElementById('flashProgressBar');
            
            if (flashTimeout) {
                clearTimeout(flashTimeout);
            }
            
            messageEl.textContent = message;
            
            const icons = {
                success: 'bi-check-circle-fill',
                info: 'bi-info-circle-fill',
                warning: 'bi-exclamation-triangle-fill',
                error: 'bi-x-circle-fill'
            };
            
            modal.className = `flash-modal show ${type}`;
            icon.className = `flash-icon ${icons[type] || icons.info}`;
            
            progressBar.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                progressBar.style.transform = 'translateX(0)';
            }, 100);
            
            flashTimeout = setTimeout(() => {
                closeFlashModal();
            }, 3000);
        }

        function closeFlashModal() {
            const modal = document.getElementById('flashModal');
            if (modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
            
            if (flashTimeout) {
                clearTimeout(flashTimeout);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const alertInfo = document.querySelector('.alert-info');
            if (alertInfo) {
                const message = alertInfo.textContent.trim();
                alertInfo.style.display = 'none';
                showFlashMessage('info', message);
            }
            
            document.addEventListener('click', function(e) {
                const modal = document.getElementById('flashModal');
                if (modal && e.target === modal) {
                    closeFlashModal();
                }
            });
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeFlashModal();
                }
            });
        });
    </script>
</body>
</html>