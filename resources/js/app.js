require('./bootstrap');

window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/*****      TEMPLATE        ******/
Vue.component('v-alert', require('./components/AlertComponent.vue').default);
Vue.component('v-modal', require('./components/ModalComponent.vue').default);
Vue.component('v-table', require('./components/TableComponent.vue').default);

// Vue.component('v-table-new', require('./components/TableNewComponent.vue').default);


/*****      BLOG        ******/    
Vue.component('v-section', require('./components/SectionComponent.vue').default);
    Vue.component('v-section-layout', require('./components/SectionLayoutComponent.vue').default);
        Vue.component('v-article', require('./components/ArticleComponent.vue').default);
        Vue.component('v-carousel', require('./components/CarouselComponent.vue').default);
            Vue.component('v-carousel-slide', require('./components/CarouselSlideComponent.vue').default);    

/*****      FORM        ******/
Vue.component('v-select', require('./components/FormSelectComponent.vue').default);
Vue.component('v-checkbox', require('./components/FormCheckBoxComponent.vue').default);

/*****      PANEL        ******/
Vue.component('v-card', require('./components/CardComponent.vue').default);

/*****      PLUGINS        ******/
Vue.component('tinymce', require('./components/TinymceComponent').default);
    Vue.component('v-blog-sumary', require('./components/BlogSumaryComponent').default);

Vue.component('v-menu', require('./components/MenuComponent.vue').default);
Vue.component('v-login', require('./components/LoginComponent.vue').default);



const app = new Vue({
    el: '#app',
});
