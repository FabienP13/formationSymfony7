/* stimulusFetch: 'eager' */
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    //Propre a stimulus 
    static values = {
        addLabel: String,
        deleteLabel: String
    }

    connect() {
        this.index = this.element.childElementCount      
        const btn = document.createElement('button')
        btn.setAttribute('class', 'btn btn-warning')
        btn.innerText = this.addLabelValue || 'Ajouter un élément'
        btn.setAttribute('type', 'button')
        btn.addEventListener('click', this.addElement)
        this.element.childNodes.forEach(this.addDeleteButton)
        this.element.append(btn)
        
    }

    /**
     * 
     * @param {MouseEvent} e 
     */
    addElement = (e) => {
        e.preventDefault()
        const element = document.createRange().createContextualFragment(
            this.element.dataset['prototype'].replace('__name__', this.index)
        ).firstElementChild
        this.addDeleteButton(element)
        this.index++
        e.currentTarget.insertAdjacentElement('beforebegin', element)
    }

    /**
     * 
     * @param {HTMLElement} item 
     */
    addDeleteButton = (item) => {
        const select = item.querySelector('select')
    const ingredientName = select ? select.options[select.selectedIndex]?.text : ''
    
    const btn = document.createElement('button')
    btn.setAttribute('class', 'btn btn-danger')
    btn.setAttribute('type', 'button')
    btn.innerText = ingredientName 
        ? `${this.deleteLabelValue || 'Supprimer'} ${ingredientName}`
        : this.deleteLabelValue || 'Supprimer'
    
    // Met à jour le label quand on change l'ingrédient
    if (select) {
        select.addEventListener('change', () => {
            btn.innerText = `${this.deleteLabelValue || 'Supprimer'} ${select.options[select.selectedIndex].text}`
        })
    }

    item.append(btn)
    btn.addEventListener('click', (e) => {
        e.preventDefault()
        item.remove()
    })
    }
}
