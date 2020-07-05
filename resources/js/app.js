import './bootstrap';
import Vue from 'vue';
import PortalVue from 'portal-vue';

Vue.use(PortalVue);

Vue.component('character-count', () => import('./components/CharacterCount'));
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.tagManager = options => {
    return {
        updateEndpoint: '',
        activeTags: [],
        loading: false,
        updateTags(event) {
            this.loading = true;

            let tagId = parseInt(event.target.value);
            let oldTags = this.activeTags;

            if (this.activeTags.indexOf(tagId) === -1) {
                this.addTag(tagId);
            } else {
                this.remTag(tagId);
            }

            axios
                .post(this.updateEndpoint, { tags: this.activeTags })
                .then(res => {
                    this.loading = false;
                    this.activeTags = res.data;
                })
                .catch(err => {
                    this.loading = false;
                    this.activeTags = oldTags;
                    console.log(err);
                });
        },
        addTag(tagId) {
            this.remTag(tagId); // To prevent duplicates.
            this.activeTags.push(tagId);
        },

        remTag(tagId) {
            this.activeTags = this.activeTags.filter(id => id !== tagId);
        },
        isChecked(tagId) {
            return this.activeTags.includes(tagId);
        },
        ...options
    };
};
Vue.component('dropdown', () => import('./components/Dropdown'));

const app = new Vue({
    el: '#app',
});
