import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

   connect() {
        

        // On cherche le composant de recherche par son attribut spécifique
        const searchComponent = document.querySelector('[data-search-state]');

        if (searchComponent) {
            // MutationObserver surveille les changements d'attributs sur le composant
            this.observer = new MutationObserver(() => {
                const isSearching = searchComponent.dataset.searchState === 'active';
                this.element.style.display = isSearching ? 'none' : 'block';
            });

            this.observer.observe(searchComponent, {
                attributes: true,
                attributeFilter: ['data-search-state']
            });
        }
    }

}