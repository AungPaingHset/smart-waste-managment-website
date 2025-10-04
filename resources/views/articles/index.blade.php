

@extends('layouts.app')

@section('content')
<style>
        /* Your existing styles here */
        :root {
        --primary-green: #42b883;
        --eco-primary-dark: #1e7e34;
        }
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
            backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.141) !important;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
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
            color:  #1e7e34;
        }

        .flash-modal.info .flash-progress-bar {
            background:  #1e7e34;
        }

        .flash-modal.info .flash-modal-content {
            border-left: 4px solid  #1e7e34;
        }


        /* Add other styles from flash-modal-styles.css */
    </style>

    <div class="container py-5" style="max-width: 1200px;">
        <div class="row">
            <div class="col-lg-6 align-self-center">

                {{-- Section Heading --}}
                <p class="section-heading">
                    Join Us in Building a Greener Future by Sharing Your Valuable Feedback with Our Eco-Conscious Community
                </p>


                {{-- Add Article CTA --}}
                <a href="{{ url('/articles/add') }}" class="btn btn-success mb-4 fw-semibold shadow-sm add-article-btn">
                    <i class="bi bi-plus-circle me-1"></i> Add Article
                </a>
            </div>
            <div class="col-lg-6" >

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mb-4">
                    {{ $articles->links() }}
                </div>
                {{-- Flash Message --}}
                @if (session('info'))
                    <div class="alert alert-info shadow-sm">
                        {{ session('info') }}
                    </div>
                @endif

                

                {{-- Article List --}}
                @foreach ($articles as $article)
                    <div class="card mb-4 article-card shadow-sm glass-btn" style="border: 1px solid black">
                        <div class="card-body">
                            {{-- Meta Info --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="meta-info">
                                    <b>{{ $article->user->name }}</b> &middot;
                                    <small>{{ $article->created_at->format('M d, Y') }}</small>
                                </div>
                                <span class="badge-comment">
                                     {{ count($article->comments) }} Comments
                                </span>
                            </div>

                            {{-- Article Body --}}
                            <div class="article-body mb-3">
                                {{ \Illuminate\Support\Str::limit($article->body, 120) }}
                            </div>

                            {{-- Link to Details --}}
                            <a href="{{ url("/articles/detail/$article->id") }}" class="card-link">
                                → View Detail
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
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
            }, 1000);
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
@endsection
