import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['table'];

    connect() {
        this.checkScrollable();
        this.addEventListeners();
        this.throttledScroll = this.throttle(this.handleScroll.bind(this), 16);
        this.throttledResize = this.throttle(this.checkScrollable.bind(this), 100);
    }

    disconnect() {
        this.removeEventListeners();
    }

    addEventListeners() {
        this.element.addEventListener('scroll', this.throttledScroll);
        window.addEventListener('resize', this.throttledResize);
    }

    removeEventListeners() {
        this.element.removeEventListener('scroll', this.throttledScroll);
        window.removeEventListener('resize', this.throttledResize);
    }

    checkScrollable() {
        const isScrollable = this.element.scrollWidth > this.element.clientWidth;

        this.element.classList.toggle('is-scrollable', isScrollable);

        if (isScrollable) {
            this.updateScrollIndicators();
        } else {
            this.element.classList.remove('show-left-shadow', 'show-right-shadow');
        }
    }

    handleScroll() {
        if (this.element.classList.contains('is-scrollable')) {
            this.updateScrollIndicators();
        }
    }

    updateScrollIndicators() {
        const scrollLeft = this.element.scrollLeft;
        const maxScrollLeft = this.element.scrollWidth - this.element.clientWidth;

        // Show left shadow when scrolled away from the start
        const showLeftShadow = scrollLeft > 5;

        // Show right shadow when there's more content to scroll to the right
        const showRightShadow = scrollLeft < maxScrollLeft - 5;

        this.element.classList.toggle('show-left-shadow', showLeftShadow);
        this.element.classList.toggle('show-right-shadow', showRightShadow);
    }

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
}