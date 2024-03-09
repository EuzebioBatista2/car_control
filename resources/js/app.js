/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});


import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import Home_page from './components/Home_page.vue';
app.component('home-page', Home_page);

import Login_page from './components/Login_page.vue';
app.component('login-page', Login_page);

import Register_page from './components/Register_page.vue';
app.component('register-page', Register_page);

import Graph_page from './components/Graph_page.vue';
app.component('graph-page', Graph_page);

import Customers_page from './components/Customers_page.vue';
app.component('customers-page', Customers_page);

import Edit_customer_page from './components/Edit_customer_page.vue';
app.component('edit-customer-page', Edit_customer_page);

import Vehicles_page from './components/Vehicles_page.vue';
app.component('vehicles-page', Vehicles_page);

import Vehicles_owner_page from './components/Vehicles_owner_page.vue';
app.component('vehicles-owner-page', Vehicles_owner_page);

import Edit_vehicle_page from './components/Edit_vehicle_page.vue';
app.component('edit-vehicle-page', Edit_vehicle_page);

import Reviews_page from './components/Reviews_page.vue';
app.component('reviews-page', Reviews_page);

import Reviews_owner_page from './components/Reviews_owner_page.vue';
app.component('reviews_owner-page', Reviews_owner_page);

import Edit_review_page from './components/Edit_review_page.vue';
app.component('edit-review-page', Edit_review_page);

import PDF_page from './components/PDF_page.vue';
app.component('pdf-page', PDF_page);

import EXCEL_page from './components/EXCEL_page.vue';
app.component('excel-page', EXCEL_page);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
