document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to all action buttons
            const actionButtons = document.querySelectorAll('.action-button');
            
            actionButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    const card = this.closest('.solution-card');
                    const cardContent = card.querySelector('.card-content');
                    const icon = card.querySelector('.solution-icon');
                    const benefits = card.querySelector('.solution-benefits');
                    
                    if (cardContent.classList.contains('expanded')) {
                        // Collapse
                        cardContent.classList.remove('expanded');
                        icon.classList.remove('show');
                        benefits.classList.remove('show');
                        
                        // Reset button text
                        if (this.innerHTML.includes('Learn More')) {
                            this.innerHTML = 'Learn More <i class="fas fa-arrow-right"></i>';
                        } else if (this.innerHTML.includes('Get Started')) {
                            this.innerHTML = 'Get Started <i class="fas fa-arrow-right"></i>';
                        } else {
                            this.innerHTML = 'Join Now <i class="fas fa-arrow-right"></i>';
                        }
                    } else {
                        // Expand
                        cardContent.classList.add('expanded');
                        
                        // Show icon and benefits with delay
                        setTimeout(() => {
                            icon.classList.add('show');
                        }, 200);
                        
                        setTimeout(() => {
                            benefits.classList.add('show');
                        }, 300);
                        
                        // Change button text
                        this.innerHTML = 'Hide Details <i class="fas fa-arrow-up"></i>';
                    }
                });
            });
        });
    