<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

let form = ref({
    name: '',
    description: '',
    photo: '',
    quantity: '',
    price: ''
})

const getPhoto = () => {

    let photo = '/img/1.jpg'

    if (form.value.photo) {
        if (form.value.photo.indexOf('base64') != -1) {

            photo = form.value.photo
        } else {
            photo = '/upload/' + form.value.photo
        }
    }

    return photo
}

const updatePhoto = (e) => {

    let file = e.target.files[0]
    let reader = new FileReader()
    let limit = 1024 * 1024 * 2

    if (file['size'] > limit) {
        return false
    }

    reader.onloadend = (file) => {
        form.value.photo = reader.result
    }

    reader.readAsDataURL(file)
}

const saveProduct = () => {

    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('description', form.value.description)
    formData.append('photo', form.value.photo)
    formData.append('type', form.value.type)
    formData.append('quantity', form.value.quantity)
    formData.append('price', form.value.price)

    axios.post('/api/addProduct', formData).then((response) => {

        form.value.name = ''
        form.value.description = ''
        form.value.photo = ''
        form.value.type = ''
        form.value.quantity = ''
        form.value.price = ''

        router.push('/products')

        toast.fire({
            icon: 'success',
            title: 'Product add successfully'
        })

    }).catch((error) => {

    })
}

</script>

<template>
    <div class="container">
        <div class="products__create ">

            <div class="products__create__titlebar dflex justify-content-between align-items-center">
                <div class="products__create__titlebar--item">

                    <h1 class="my-1">Add Product</h1>
                </div>
                <div class="products__create__titlebar--item">

                    <button class="btn btn-secondary ml-1" @click="saveProduct()">
                        Save
                    </button>
                </div>
            </div>

            <div class="products__create__cardWrapper mt-2">
                <div class="products__create__main">
                    <div class="products__create__main--addInfo card py-2 px-2 bg-white">
                        <p class="mb-1">Name</p>
                        <input type="text" class="input" v-model="form.name">

                        <p class="my-1">Description (optional)</p>
                        <textarea cols="10" rows="5" class="textarea" v-model="form.description"></textarea>

                        <div class="products__create__main--media--images mt-2">
                            <ul class="products__create__main--media--images--list list-unstyled">
                                <li class="products__create__main--media--images--item">
                                    <div class="products__create__main--media--images--item--imgWrapper">
                                        <img class="products__create__main--media--images--item--img" :src="getPhoto()"
                                            alt="" />
                                    </div>
                                </li>
                                <!-- upload image small -->
                                <li class="products__create__main--media--images--item">
                                    <form class="products__create__main--media--images--item--form">
                                        <label class="products__create__main--media--images--item--form--label"
                                            for="myfile">Add Image</label>
                                        <input class="products__create__main--media--images--item--form--input"
                                            type="file" id="myfile" @change="updatePhoto">
                                    </form>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="products__create__sidebar">
                    <!-- Product Organization -->
                    <div class="card py-2 px-2 bg-white">

                        <!-- Product unit -->
                        <div class="my-3">
                            <p>Product type</p>
                            <input type="text" class="input" v-model="form.type">
                        </div>
                        <hr>

                        <!-- Product invrntory -->
                        <div class="my-3">
                            <p>Inventory</p>
                            <input type="text" class="input" v-model="form.quantity">
                        </div>
                        <hr>

                        <!-- Product Price -->
                        <div class="my-3">
                            <p>Price</p>
                            <input type="text" class="input" v-model="form.price">
                        </div>
                    </div>

                </div>
            </div>
            <!-- Footer Bar -->
            <div class="dflex justify-content-between align-items-center my-3">
                <p></p>
                <button class="btn btn-secondary" @click="saveProduct()">Save</button>
            </div>

        </div>
    </div>
</template>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Fira sans', sans-serif;
}

body {

    background: #6c5ce7;
    color: #FFF;
}

main {
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 2rem;
}

main h1 {
    font-size: 2.5rem;
    text-transform: capitalize;
    margin-bottom: 0.5rem;
}

main h1~p {
    margin-bottom: 2rem;
}


.container {
    width: 100%;
    max-width: 780px;
    margin-top: 5rem;
    margin-left: auto;
    margin-right: auto;
}


.my-3 {
    margin-top: 30px;
    margin-bottom: 30px;
}

.mt-2 {
    margin-top: 20px;
}


.bg-white {
    background: white;
}

.py-2 {
    padding-top: 20px;
    padding-bottom: 20px;
}

.px-2 {
    padding-left: 20px;
    padding-right: 20px;
}

.table--heading {
    padding: 0 30px;
    gap: 10px;
    display: -ms-grid;
    display: grid;
    -ms-grid-columns: (minmax(100px, 1fr))[auto-fit];
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    color: #6a727a;
    font-size: 14px;
    font-weight: 500;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 1.2rem;
    background-color: #f1f1f1;

}

.products__list__heading {
    -ms-grid-columns: 80px 1fr 140px 120px 100px;
    grid-template-columns: 50px 1fr 120px 120px 120px;
}



.table--items {
    padding: 10px 30px !important;
    gap: 10px;
    display: -ms-grid;
    display: grid;
    -ms-grid-columns: (minmax(100px, 1fr))[auto-fit];
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-bottom: 1px solid #e0e0e0;
    padding: 0.6rem 0;
    color: #6a727a;
    background-color: #f1f1f1;
}

.products__list__item {
    border-bottom: 1px solid #e0e0e0;
    -ms-grid-columns: 80px 1fr 140px 120px 100px;
    grid-template-columns: 50px 1fr 120px 120px 120px;
}

.card {

    -webkit-box-shadow: 0 6px 13px -12px rgb(50 50 93 / 20%), 0 3px 7px -3px rgb(110 110 110 / 10%);
    box-shadow: 0 6px 13px -12px rgb(50 50 93 / 20%), 0 3px 7px -3px rgb(110 110 110 / 10%);
    border-radius: 4px;
}

.btn-icon {
    border: 1px solid #e0e0e0;
    background: none;
    width: 35px;
    height: 35px;
    border-radius: 4px;
    color: #6a727a;
    cursor: pointer;
}

.btn-icon-success:hover {

    background: rgb(47, 214, 111);
    color: white;

}

.btn-icon-danger:hover {
    background: crimson;
    color: white;

}


.align-items-center {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.justify-content-between {
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}

.dflex {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.btn-secondary {
    background: #FFF;
    color: black;
}

.btn {
    border: 1px solid #6a727a;
    padding: 9px 15px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-secondary:hover {
    background: #f1f1f1;
    color: #6a727a;
}

.my-1 {
    margin-top: 10px;
    margin-bottom: 30px;
}












.products__create__cardWrapper {
    display: -ms-grid;
    display: grid;
    -ms-grid-columns: 1fr minmax(auto, 290px);
    grid-template-columns: 1fr minmax(auto, 290px);
    grid-gap: 20px;
    color: #6a727a;
}

.card {
    border: 1px solid #e0e0e0;
    -webkit-box-shadow: 0 6px 13px -12px rgb(50 50 93 / 20%), 0 3px 7px -3px rgb(110 110 110 / 10%);
    box-shadow: 0 6px 13px -12px rgb(50 50 93 / 20%), 0 3px 7px -3px rgb(110 110 110 / 10%);
    border-radius: 4px;
}

.mb-1 {
    margin-bottom: 10px;
}

.input {
    padding: 9px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    width: 100%;
}

.my-1 {
    margin-top: 10px;
    margin-bottom: 10px;
}

.textarea {
    padding: 9px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    width: 100%;
    font-size: 1.1rem;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.checkbox-container {
    display: block;
    position: relative;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 14px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.mt-3 {
    margin-top: 30px;
}

.products__create__main--pricing--col {
    display: -ms-grid;
    display: grid;
    -ms-grid-columns: 1fr 1fr;
    grid-template-columns: 1fr 1fr;
    grid-gap: 20px;
}

.inputAdd {
    padding: 9px 15px;
    border-top: 1px solid #e0e0e0;
    border-left: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    border-right: none;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    width: 100%;
}

.inputAdd__Btn {
    background: #5463c1;
    color: white;
    border-top: 1px solid #5463c1;
    border-right: 1px solid #5463c1;
    border-bottom: 1px solid #5463c1;
    border-left: none;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    padding: 9px 15px;
    cursor: pointer;
}

.inputSelect {
    padding: 9px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    width: 100%;
    color: #454f5b;
    min-width: 200px;
}

.products__create__main--media--images--item--form {
    border: 2px dashed #6a727a;
    position: relative;
    cursor: pointer;
}

.products__create__main--media--form {
    border: 2px dashed #6a727a;
    position: relative;
    cursor: pointer;
}



.products__create__main--media--images--list {
    display: -ms-grid;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-gap: 5px;
}

.list-unstyled {
    list-style: none;
}

.products__create__main--media--images--item {
    position: relative;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
}

.products__create__main--media--images--item--imgWrapper {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    width: 117px;
}

.products__create__main--media--images--item--img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
}

.products__create__main--media--images--item--form--label {
    padding: 9px 15px;
    border-radius: 4px;
    position: absolute;
    text-align: center;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.products__create__main--media--images--item--form--input {
    height: 100px;
    opacity: 0;
    width: 100%;
    cursor: pointer;
}
</style>
