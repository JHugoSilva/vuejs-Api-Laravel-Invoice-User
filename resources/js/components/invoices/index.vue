<script setup>
    import { onMounted, ref } from "vue";
    import { useRouter } from "vue-router";

    const router = useRouter()
    const invoices = ref([])
    const searchInvoice = ref([])

    onMounted(async () => {
        await getInvoices()
    })

    const getInvoices = async () => {
        let response = await axios.get('/api/getInvoices')
        invoices.value = response.data.invoices
    }

    const search = async () => {
        let response = await axios.get('/api/getSearchInvoice?s='+searchInvoice.value)
        invoices.value = response.data.invoices
    }

    const newInvoice = async () => {
        await axios.get('/api/createInvoice')
        router.push('/invoice/new')
    }

    const onShow = (id) => {
        router.push('/invoice/show/'+id)
    }

</script>

<template>
  <div class="container">
    <!--==================== INVOICE LIST ====================-->
    <div class="invoices">

        <div class="card__header">
            <div>
                <h2 class="invoice__title">Invoices</h2>
            </div>
            <div>
                <a class="btn btn-secondary" @click="newInvoice">
                    New Invoice
                </a>
                <router-link to="/products" class="btn btn-secondary">Products</router-link>
            </div>
        </div>

        <div class="table card__content">
            <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <div class="table--filter--listWrapper">
                    <ul class="table--filter--list">
                        <li>
                            <p class="table--filter--link table--filter--link--active">
                                All
                            </p>
                        </li>
                        <li>
                            <p class="table--filter--link ">
                                Paid
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table--search">
                <div class="table--search--wrapper">
                    <select class="table--search--select" name="" id="">
                        <option value="">Filter</option>
                    </select>
                </div>
                <div class="relative">
                    <i class="table--search--input--icon fas fa-search "></i>
                    <input class="table--search--input" type="text" v-model="searchInvoice" @keyup="search()" placeholder="Search invoice">
                </div>
            </div>

            <div class="table--heading">
                <p>ID</p>
                <p>Date</p>
                <p>Number</p>
                <p>Customer</p>
                <p>Due Date</p>
                <p>Total</p>
            </div>

            <!-- item 1 -->
            <template v-if="invoices.length > 0">
                <div class="table--items" v-for="(invoice, index) in invoices" :key="index">
                    <a href="#" @click="onShow(invoice.id)" class="table--items--transactionId">#{{ invoice.id }}</a>
                    <p>{{ invoice.date }}</p>
                    <p>#{{ invoice.number }}</p>
                    <p>{{ invoice.customer.firstname }}</p>
                    <p>{{ invoice.due_date }}</p>
                    <p> $ {{ invoice.total }}</p>
                </div>
            </template>
            <template v-else>
                <h1>Invoice Not Found</h1>
            </template>


        </div>

    </div>
  </div>
    <br><br><br>
</template>
