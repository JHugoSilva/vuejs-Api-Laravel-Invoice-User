import { createRouter, createWebHistory } from 'vue-router'

import InvoiceIndex from '../components/invoices/index.vue'
import InvoiceNew from '../components/invoices/new.vue'
import InvoiceShow from '../components/invoices/show.vue'
import InvoiceEdit from '../components/invoices/edit.vue'
import ProdcutIndex from '../components/products/index.vue'
import ProdcutNew from '../components/products/new.vue'
import ProdcutEdit from '../components/products/edit.vue'
import NotFound from '../components/NotFound.vue'

const routes = [
    {
        path: '/',
        component: InvoiceIndex,
    },
    {
        path: '/invoice/new',
        component: InvoiceNew
    },
    {
        path: '/invoice/show/:id',
        component: InvoiceShow,
        props: true
    },
    {
        path: '/invoice/edit/:id',
        component: InvoiceEdit,
        props: true
    },
    {
        path: '/invoice/edit/:id',
        component: InvoiceShow,
        props: true
    },
    {
        path: '/products',
        component: ProdcutIndex
    },
    {
        path: '/product/new',
        component: ProdcutNew
    },
    {
        path: '/product/edit/:id',
        component: ProdcutEdit,
        props: true
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


export default router
