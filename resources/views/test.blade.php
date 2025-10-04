<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Electrical Recycling - Glass Effect Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
      /* Reset and Base Styles */
      * {
        box-sizing: border-box;
      }

      body {
        margin: 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #e8f5e8 0%, #f8f9fa 50%, #e0f2e0 100%);
        min-height: 100vh;
        line-height: 1.6;
      }

      /* Custom Bootstrap Color Variables */
      :root {
        --bs-primary: #4caf50;
        --bs-primary-rgb: 76, 175, 80;
        --bs-secondary: #66bb6a;
        --glass-bg: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.18);
        --glass-shadow: rgba(76, 175, 80, 0.37);
      }

      /* Section Styling */
      .electrical-recycling-section {
        position: relative;
        overflow: hidden;
      }

      .electrical-recycling-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
          radial-gradient(circle at 20% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
          radial-gradient(circle at 80% 20%, rgba(102, 187, 106, 0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: -1;
      }

      /* Glass Card Effect */
      .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid var(--glass-border);
        box-shadow: 
          0 8px 32px var(--glass-shadow),
          inset 0 1px 0 rgba(255, 255, 255, 0.3);
        padding: 2.5rem 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }

      .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(255, 255, 255, 0.2),
          transparent
        );
        transition: left 0.5s;
      }

      .glass-card:hover {
        transform: translateY(-8px);
        box-shadow: 
          0 20px 40px rgba(31, 38, 135, 0.2),
          inset 0 1px 0 rgba(255, 255, 255, 0.4);
        border-color: rgba(255, 255, 255, 0.3);
      }

      .glass-card:hover::before {
        left: 100%;
      }

      /* Card Icon Styling */
      .card-icon {
        position: relative;
        margin-bottom: 1.5rem;
      }

      .card-icon i {
        transition: all 0.3s ease;
        filter: drop-shadow(0 4px 8px rgba(76, 175, 80, 0.2));
      }

      .glass-card:hover .card-icon i {
        transform: scale(1.1);
        filter: drop-shadow(0 6px 12px rgba(76, 175, 80, 0.3));
      }

      /* Typography */
      .display-5 {
        font-weight: 700;
        background: linear-gradient(135deg, var(--bs-primary), #388e3c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
      }

      .card-title {
        font-weight: 600;
        color: #2e7d32;
        font-size: 1.25rem;
        margin-bottom: 1rem;
      }

      .lead {
        font-size: 1.125rem;
        color: #546e7a;
        font-weight: 400;
      }

      /* Glass Button */
      .btn-glass {
        background: rgba(76, 175, 80, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(76, 175, 80, 0.3);
        color: var(--bs-primary);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
      }

      .btn-glass::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(76, 175, 80, 0.1),
          transparent
        );
        transition: left 0.5s;
      }

      .btn-glass:hover {
        background: rgba(76, 175, 80, 0.2);
        border-color: rgba(76, 175, 80, 0.5);
        color: #2e7d32;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
      }

      .btn-glass:hover::before {
        left: 100%;
      }

      .btn-glass:focus {
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .glass-card {
          padding: 2rem 1.5rem;
          margin-bottom: 1rem;
        }
        
        .card-icon i {
          font-size: 2rem !important;
        }
        
        .display-5 {
          font-size: 2rem;
        }
      }

      @media (max-width: 576px) {
        .glass-card {
          padding: 1.5rem 1rem;
        }
        
        .btn-glass {
          padding: 0.5rem 0.5rem;
          font-size: 0.5rem;
        }
      }

      /* Enhanced Animations */
      @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
      }

      .card-icon i {
        animation: float 6s ease-in-out infinite;
      }

      .glass-card:nth-child(1) .card-icon i { animation-delay: 0s; }
      .glass-card:nth-child(2) .card-icon i { animation-delay: 1.5s; }
      .glass-card:nth-child(3) .card-icon i { animation-delay: 3s; }
      .glass-card:nth-child(4) .card-icon i { animation-delay: 4.5s; }

      /* Improved Focus States for Accessibility */
      .glass-card:focus-within {
        outline: 2px solid var(--bs-primary);
        outline-offset: 4px;
      }

      .btn-glass:focus:not(:focus-visible) {
        outline: none;
      }

      .btn-glass:focus-visible {
        outline: 2px solid var(--bs-primary);
        outline-offset: 2px;
      }
    </style>
  </head>
  <body>
    <section class="electrical-recycling-section py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
              <h2 class="display-5 fw-bold text-primary mb-3">Old electricals? What you can do</h2>
              <p class="lead text-muted">Anything with a plug, battery or cable can be recycled.</p>
            </div>
            
            <!-- Cards Grid -->
            <div class="row g-4">
              <div class="col-md-3">
                <div class="glass-card text-center h-100">
                  <div class="card-icon mb-4">
                    <i class="fas fa-tools fa-3x text-primary"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title mb-3">Repair</h5>
                    <a href="#" class="btn btn-outline-primary btn-glass">Learn More</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="glass-card text-center h-100">
                  <div class="card-icon mb-4">
                    <i class="fas fa-heart fa-3x text-primary"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title mb-3">Donate</h5>
                    <a href="#" class="btn btn-outline-primary btn-glass">Learn More</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="glass-card text-center h-100">
                  <div class="card-icon mb-4">
                    <i class="fas fa-dollar-sign fa-3x text-primary"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title mb-3">Sell</h5>
                    <a href="#" class="btn btn-outline-primary btn-glass">Learn More</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="glass-card text-center h-100">
                  <div class="card-icon mb-4">
                    <i class="fas fa-recycle fa-3x text-primary"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title mb-3">Recycle</h5>
                    <a href="#" class="btn btn-outline-primary btn-glass">Learn More</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>