import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['scrollable'];

    connect() {
        this.checkScrollable();
        this.addEventListeners();
        this.throttledScroll = this.throttle(this.handleScroll.bind(this), 16);
        this.throttledResize = this.throttle(this.checkScrollable.bind(this), 100);

        // Debug info
        console.log('Table scroll controller connected', {
            element: this.element,
            scrollableTarget: this.scrollableTarget
        });
    }

    disconnect() {
        this.removeEventListeners();
    }

    addEventListeners() {
        if (this.hasScrollableTarget) {
            this.scrollableTarget.addEventListener('scroll', this.throttledScroll);
        }
        window.addEventListener('resize', this.throttledResize);
    }

    removeEventListeners() {
        if (this.hasScrollableTarget) {
            this.scrollableTarget.removeEventListener('scroll', this.throttledScroll);
        }
        window.removeEventListener('resize', this.throttledResize);
    }

    checkScrollable() {
        if (!this.hasScrollableTarget) return;

        const scrollableElement = this.scrollableTarget;
        const isScrollable = scrollableElement.scrollWidth > scrollableElement.clientWidth;

        console.log('Checking scrollable:', {
            scrollWidth: scrollableElement.scrollWidth,
            clientWidth: scrollableElement.clientWidth,
            isScrollable
        });

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
        if (!this.hasScrollableTarget) return;

        const scrollableElement = this.scrollableTarget;
        const scrollLeft = scrollableElement.scrollLeft;
        const maxScrollLeft = scrollableElement.scrollWidth - scrollableElement.clientWidth;

        // Show left shadow when scrolled away from the start
        const showLeftShadow = scrollLeft > 5;

        // Show right shadow when there's more content to scroll to the right
        const showRightShadow = scrollLeft < maxScrollLeft - 5;

        console.log('Updating indicators:', {
            scrollLeft,
            maxScrollLeft,
            showLeftShadow,
            showRightShadow
        });

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