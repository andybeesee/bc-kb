import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = [
        'input',
    ]

    connect() {

    }

    open(e) {
        if(e.target.tagName === 'INPUT') {
            this.inputTarget.show();
        }
    }
}

