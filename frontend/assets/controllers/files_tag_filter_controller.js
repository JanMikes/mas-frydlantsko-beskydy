import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['filter', 'item'];
    static values = { activeTags: Array };

    connect() {
        this.activeTagsValue = [];
        this.updateItems();
    }

    toggleFilter(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const tagSlug = button.dataset.tag;

        if (this.activeTagsValue.includes(tagSlug)) {
            this.activeTagsValue = this.activeTagsValue.filter(tag => tag !== tagSlug);
            button.classList.remove('active');
        } else {
            this.activeTagsValue = [...this.activeTagsValue, tagSlug];
            button.classList.add('active');
        }

        this.updateItems();
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
    }
}
