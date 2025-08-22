import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['container', 'item', 'prevArrow', 'nextArrow'];

    connect() {
        this.updateArrowVisibility();
        this.addScrollListeners();
        
        // Add a small delay to ensure elements are properly rendered
        setTimeout(() => {
            this.updateArrowVisibility();
        }, 100);
    }

    disconnect() {
        this.removeScrollListeners();
    }

    scrollPrev() {
        const container = this.containerTarget;
        const scrollAmount = this.getScrollAmount();
        
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    }

    scrollNext() {
        const container = this.containerTarget;
        const scrollAmount = this.getScrollAmount();
        
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    getScrollAmount() {
        if (this.itemTargets.length === 0) return 0;
        
        // Get the width of one item plus gap
        const item = this.itemTargets[0];
        const itemWidth = item.offsetWidth;
        const gap = parseInt(getComputedStyle(this.containerTarget).gap) || 0;
        
        // Scroll by the width of one item
        return itemWidth + gap;
    }

    updateArrowVisibility() {
        const shouldShowArrows = this.itemTargets.length > 3;
        
        if (this.hasPrevArrowTarget) {
            this.prevArrowTarget.style.display = shouldShowArrows ? 'inline-block' : 'none';
        }
        
        if (this.hasNextArrowTarget) {
            this.nextArrowTarget.style.display = shouldShowArrows ? 'inline-block' : 'none';
        }
    }

    addScrollListeners() {
        if (this.hasContainerTarget) {
            this.boundScrollHandler = this.handleScroll.bind(this);
            this.containerTarget.addEventListener('scroll', this.boundScrollHandler);
        }
    }

    removeScrollListeners() {
        if (this.hasContainerTarget && this.boundScrollHandler) {
            this.containerTarget.removeEventListener('scroll', this.boundScrollHandler);
        }
    }

    handleScroll() {
        // Optional: Update arrow states based on scroll position
        if (this.hasPrevArrowTarget && this.hasNextArrowTarget) {
            const container = this.containerTarget;
            const isAtStart = container.scrollLeft <= 0;
            const isAtEnd = container.scrollLeft >= (container.scrollWidth - container.clientWidth);
            
            // Optional: Add disabled state styling
            this.prevArrowTarget.classList.toggle('disabled', isAtStart);
            this.nextArrowTarget.classList.toggle('disabled', isAtEnd);
        }
    }
}
