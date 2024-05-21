<script setup>
    import { onMounted, ref } from 'vue'
    import { useRouter } from 'vue-router'

    const router = useRouter()
    const products = ref([])

    const getProducts = async () => {

        let response = await axios.get('/api/products')
        products.value = response.data.products;
    }

    const ourImage = (img) => {
        return '/upload/'+img
    }

    const newProduct = () => {
        router.push('/product/new')
    }

    const onEdit = (id) => {
        router.push('/product/edit/'+id)
    }

    const deleteProduct = (id, i) => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You can\'t got back',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, delete it!'
        }).then((result)=>{
            if (result.value) {
                products.value.splice(i, 1)
                if (id != undefined) {
                    axios.delete(`/api/product/${id}`).then(() => {
                        Swal.fire(
                            'Delete',
                            'Product delete successfully',
                            'success'
                        )
                    }).catch((error) => {
                        Swal.fire(
                            'Failed!',
                            'There was something wrong.',
                            'Warning'
                        )
                    })
                }
            }
        }).catch((error) => {
            console.log(error);
        })
    }

    onMounted(async () => {
        await getProducts()
    })


</script>
<template>
    <div class="container">

      <div class="products__list table  my-3">

          <div class="customers__titlebar dflex justify-content-between align-items-center">
              <div class="customers__titlebar--item">
                  <h1 class="my-1">Products</h1>
              </div>
              <div class="customers__titlebar--item">
                  <button class="btn btn-secondary my-1" @click="newProduct()">
                      Add Product
                  </button>
              </div>
          </div>

          <div class="table--heading mt-2 products__list__heading " style="padding-top: 20px;background:#FFF">
              <!-- <p class="table--heading--col1">&#32;</p> -->
              <p class="table--heading--col1">image</p>
              <p class="table--heading--col2">
                  Product
              </p>
              <p class="table--heading--col4">Type</p>
              <p class="table--heading--col3">
                  Inventory
              </p>
              <!-- <p class="table--heading--col5">&#32;</p> -->
              <p class="table--heading--col5">actions</p>
          </div>

              <!-- product 1 -->
            <template v-if="products.length > 0">
                <div class="table--items products__list__item" v-for="(item, i) in products" :key="i">
            <div class="products__list__item--imgWrapper">
                <template v-if="item.photo">
                    <img class="products__list__item--img" :src="ourImage(item.photo)"  style="height: 40px;">
                </template>
                <template v-else>
                    <img class="products__list__item--img" :src="'storage/img/1.jpg'"  style="height: 40px;">
                </template>
            </div>
            <router-link :to="`product/edit/${item.id}`" class="table--items--col2">
                {{ item.name }}
            </router-link>
            <p class="table--items--col2">
                {{ item.type }}
            </p>
            <p class="table--items--col3">
                {{ item.quantity }}
            </p>
            <div>
                <button class="btn-icon btn-icon-success" @click="onEdit(item.id)">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="btn-icon btn-icon-danger" @click="deleteProduct(item.id, i)">
                    <i class="far fa-trash-alt"></i>
                </button>
            </div>
        </div>
            </template>
            <template v-else>
                <p>Não existe produtos cadastros</p>
            </template>

      </div>
  </div>
</template>
