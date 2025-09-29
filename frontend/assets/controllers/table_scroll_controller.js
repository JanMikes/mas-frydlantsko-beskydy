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

        const showLeftShadow = scrollLeft > 10;
        const showRightShadow = scrollLeft < maxScrollLeft - 10;

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