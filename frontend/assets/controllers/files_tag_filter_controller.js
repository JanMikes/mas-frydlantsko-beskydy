import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['filter', 'item', 'hiddenTags', 'showMoreButton', 'allButton', 'clearFiltersLink'];
    static values = {
        activeTags: Array,
        autoSelectFirst: { type: Boolean, default: true }
    };

    connect() {
        this.activeTagsValue = [];

        // If autoSelectFirst is disabled, activate the "Všechny" button by default
        if (!this.autoSelectFirstValue) {
            if (this.hasAllButtonTarget) {
                this.allButtonTarget.classList.add('active');
            }
        }
        // If there are at least 2 filters and autoSelectFirst is enabled, activate the first one by default
        else if (this.autoSelectFirstValue && this.filterTargets.length >= 2) {
            const firstFilter = this.filterTargets[0];
            const firstTagSlug = firstFilter.dataset.tag;
            this.activeTagsValue = [firstTagSlug];
            firstFilter.classList.add('active');
        }
        // Otherwise, activate "Všechny" button
        else if (this.hasAllButtonTarget) {
            this.allButtonTarget.classList.add('active');
        }

        this.updateItems();
    }

    toggleFilter(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const tagSlug = button.dataset.tag;

        if (this.activeTagsValue.includes(tagSlug)) {
            this.activeTagsValue = this.activeTagsValue.filter(tag => tag !== tagSlug);
            button.classList.remove('active');

            // If no filters are active, activate "Všechny" button
            if (this.activeTagsValue.length === 0 && this.hasAllButtonTarget) {
                this.allButtonTarget.classList.add('active');
            }
        } else {
            this.activeTagsValue = [...this.activeTagsValue, tagSlug];
            button.classList.add('active');

            // Deactivate "Všechny" button when any filter is selected
            if (this.hasAllButtonTarget) {
                this.allButtonTarget.classList.remove('active');
            }
        }

        this.updateItems();
    }

    clearFilters(event) {
        event.preventDefault();

        // Deactivate all filter buttons
        this.filterTargets.forEach(button => {
            button.classList.remove('active');
        });

        // Clear active tags
        this.activeTagsValue = [];

        // Activate "Všechny" button
        if (this.hasAllButtonTarget) {
            this.allButtonTarget.classList.add('active');
        }

        this.updateItems();
    }

    showMoreTags(event) {
        event.preventDefault();

        // Show hidden tags
        if (this.hasHiddenTagsTarget) {
            this.hiddenTagsTarget.classList.remove('d-none');
            this.hiddenTagsTarget.classList.add('d-inline-block');
        }

        // Hide the "show more" button
        if (this.hasShowMoreButtonTarget) {
            this.showMoreButtonTarget.classList.add('d-none');
        }
    }

    updateItems() {
        this.itemTargets.forEach(item => {
            const itemTags = item.dataset.tags ? item.dataset.tags.split(',') : [];

            if (this.activeTagsValue.length === 0) {
                item.classList.remove('d-none');
                item.classList.add('d-block');
            } else {
                const hasMatchingTag = this.activeTagsValue.some(activeTag => itemTags.includes(activeTag));

                if (hasMatchingTag) {
                    item.classList.remove('d-none');
                    item.classList.add('d-block');
                } else {
                    item.classList.remove('d-block');
                    item.classList.add('d-none');
                }
            }
        });

        // Show/hide clear filters link based on active filters
        if (this.hasClearFiltersLinkTarget) {
            if (this.activeTagsValue.length > 0) {
                this.clearFiltersLinkTarget.classList.remove('d-none');
            } else {
                this.clearFiltersLinkTarget.classList.add('d-none');
            }
        }
    }
}
