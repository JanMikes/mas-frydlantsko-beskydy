import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['filter', 'item', 'hiddenTags', 'showMoreButton', 'allButton', 'clearFiltersLink'];
    static values = {
        activeTags: Array,
        autoSelectFirst: { type: Boolean, default: true }
    };

    connect() {
        this.activeTagsValue = [];
        this.activeCategories = [];
        this.activeTags = [];

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
            const filterType = firstFilter.dataset.filterType;

            if (filterType === 'category') {
                this.activeCategories = [firstTagSlug];
            } else if (filterType === 'tag') {
                this.activeTags = [firstTagSlug];
            } else {
                // Backward compatibility: if no filter type, use old behavior
                this.activeTagsValue = [firstTagSlug];
            }
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
        const filterType = button.dataset.filterType;

        // Check if we're using the new filter-type system
        if (filterType === 'category' || filterType === 'tag') {
            // New behavior: separate category and tag filtering
            const targetArray = filterType === 'category' ? this.activeCategories : this.activeTags;
            const index = targetArray.indexOf(tagSlug);

            if (index > -1) {
                targetArray.splice(index, 1);
                button.classList.remove('active');
            } else {
                targetArray.push(tagSlug);
                button.classList.add('active');
            }

            // If no filters are active, activate "Všechny" button
            if (this.activeCategories.length === 0 && this.activeTags.length === 0 && this.hasAllButtonTarget) {
                this.allButtonTarget.classList.add('active');
            } else if (this.hasAllButtonTarget) {
                this.allButtonTarget.classList.remove('active');
            }
        } else {
            // Backward compatibility: old behavior without filter types
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
        }

        this.updateItems();
    }

    clearFilters(event) {
        event.preventDefault();

        // Deactivate all filter buttons
        this.filterTargets.forEach(button => {
            button.classList.remove('active');
        });

        // Clear all active filters
        this.activeTagsValue = [];
        this.activeCategories = [];
        this.activeTags = [];

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
        // Check if we're using the new filter-type system (categories + tags)
        const hasFilterTypes = this.activeCategories.length > 0 || this.activeTags.length > 0;
        const hasOldFilters = this.activeTagsValue.length > 0;

        this.itemTargets.forEach(item => {
            const itemTags = item.dataset.tags ? item.dataset.tags.split(',') : [];

            if (hasFilterTypes) {
                // New behavior: (ANY category OR no categories) AND (ANY tag OR no tags)
                const noCategoriesSelected = this.activeCategories.length === 0;
                const noTagsSelected = this.activeTags.length === 0;

                const matchesCategory = noCategoriesSelected ||
                    this.activeCategories.some(category => itemTags.includes(category));

                const matchesTag = noTagsSelected ||
                    this.activeTags.some(tag => itemTags.includes(tag));

                const shouldShow = matchesCategory && matchesTag;

                if (shouldShow) {
                    item.classList.remove('d-none');
                    item.classList.add('d-block');
                } else {
                    item.classList.remove('d-block');
                    item.classList.add('d-none');
                }
            } else {
                // Backward compatibility: old OR behavior for pages without filter types
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
            }
        });

        // Show/hide clear filters link based on active filters
        if (this.hasClearFiltersLinkTarget) {
            const hasAnyFilters = hasFilterTypes || hasOldFilters;
            if (hasAnyFilters) {
                this.clearFiltersLinkTarget.classList.remove('d-none');
            } else {
                this.clearFiltersLinkTarget.classList.add('d-none');
            }
        }
    }
}
