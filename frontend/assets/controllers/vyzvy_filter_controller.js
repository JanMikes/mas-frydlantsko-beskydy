import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['filter', 'item', 'allFilter'];
    static values = { activeFilters: Array };

    connect() {
        this.activeFiltersValue = [];
        this.updateItems();
    }

    toggleFilter(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const filterSlug = button.dataset.kategorie;

        if (this.activeFiltersValue.includes(filterSlug)) {
            this.activeFiltersValue = this.activeFiltersValue.filter(filter => filter !== filterSlug);
            button.classList.remove('active');
        } else {
            this.activeFiltersValue = [...this.activeFiltersValue, filterSlug];
            button.classList.add('active');
        }

        // Update "Všechny" filter state
        this.updateAllFilterState();
        this.updateItems();
    }

    toggleAllFilter(event) {
        event.preventDefault();

        // If "Všechny" is currently active (all filters are off), do nothing
        if (this.activeFiltersValue.length === 0) {
            return;
        }

        // Clear all active filters
        this.activeFiltersValue = [];
        
        // Remove active class from all filter buttons
        this.filterTargets.forEach(filter => {
            filter.classList.remove('active');
        });

        this.updateAllFilterState();
        this.updateItems();
    }

    updateAllFilterState() {
        const allButton = this.allFilterTarget;
        
        if (this.activeFiltersValue.length === 0) {
            allButton.classList.add('active');
        } else {
            allButton.classList.remove('active');
        }
    }

    updateItems() {
        this.itemTargets.forEach(item => {
            const itemKategorie = item.dataset.kategorie ? item.dataset.kategorie.split(',') : [];
            
            if (this.activeFiltersValue.length === 0) {
                // Show all items when no filters are active
                item.classList.remove('d-none');
                item.classList.add('d-block');
            } else {
                // Show item if it has at least one matching category
                const hasMatchingCategory = this.activeFiltersValue.some(activeFilter =>
                    itemKategorie.includes(activeFilter)
                );
                
                if (hasMatchingCategory) {
                    item.classList.remove('d-none');
                    item.classList.add('d-block');
                } else {
                    item.classList.remove('d-block');
                    item.classList.add('d-none');
                }
            }
        });
    }
}
