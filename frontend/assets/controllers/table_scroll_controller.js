import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['wrapper', 'container'];

    connect() {
        this.checkScrollability();
        this.addScrollListeners();

        // Check scrollability after a short delay to ensure elements are rendered
        setTimeout(() => {
            this.checkScrollability();
        }, 100);

        // Add resize listener to handle window resize
        this.boundResizeHandler = this.handleResize.bind(this);
        window.addEventListener('resize', this.boundResizeHandler);
    }

    disconnect() {
        this.removeScrollListeners();
        window.removeEventListener('resize', this.boundResizeHandler);
    }

    checkScrollability() {
        const container = this.containerTarget;
        const wrapper = this.wrapperTarget;
        const isScrollable = container.scrollWidth > container.clientWidth;

        // Add or remove scrollable class on wrapper for shadows
        wrapper.classList.toggle('table-scrollable', isScrollable);
        // Add class to container for scrollbar styling
        container.classList.toggle('table-scrollable', isScrollable);

        if (isScrollable) {
            this.updateScrollIndicators();
        }
    }

    updateScrollIndicators() {
        const container = this.containerTarget;
        const wrapper = this.wrapperTarget;
        const scrollLeft = container.scrollLeft;
        const maxScroll = container.scrollWidth - container.clientWidth;

        // Determine if we're at the start, middle, or end
        const isAtStart = scrollLeft <= 5; // Small threshold for precision
        const isAtEnd = scrollLeft >= maxScroll - 5;

        // Update CSS classes on wrapper for shadow positioning
        // Left shadow: hide only when at start, show everywhere else
        wrapper.classList.toggle('scroll-at-start', isAtStart);
        // Right shadow: hide only when at end, show everywhere else
        wrapper.classList.toggle('scroll-at-end', isAtEnd);
        // Middle state: when not at start AND not at end
        wrapper.classList.toggle('scroll-in-middle', !isAtStart && !isAtEnd);
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
        this.updateScrollIndicators();
    }

    handleResize() {
        // Debounce resize events
        clearTimeout(this.resizeTimeout);
        this.resizeTimeout = setTimeout(() => {
            this.checkScrollability();
        }, 150);
    }
}