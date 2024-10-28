<script setup>
import { ref } from 'vue';

const dropdownItems = ref([
    { name: 'Option 1', id: '1' },
    { name: 'Option 2', id: '2' },
    { name: 'Option 3', id: '3' }
]);

const dropdownItem = ref(null);
const client = ref({});


function addClient() {
    // console.log('clic');
    axios.post('/api/clients',client.value)
    .then(response =>{
                console.log(response);
                //client.value = response.data;
            })
            .catch(error=>{
                console.log(error);
            })
}

</script>


<template>
    <div class="grid">
        <div class="col-12 md:col-6">
            <div class="card p-fluid">

                {{ client }}
                <h5>Nou Client</h5>
                <div class="field">
                    <label for="name1">Nom</label>
                    <InputText v-model="client.name" id="name1" type="text" />
                </div>
                <div class="field">
                    <label for="cognom">Cognom</label>
                    <InputText v-model="client.surname1" id="cognom" type="text" />
                </div>
                <div class="field">
                    <label for="cognom2">Segon Cognom</label>
                    <InputText v-model="client.surname2"  id="cognom2" type="text" />
                </div>
                <div class="field">
                    <label for="nif">Nif</label>
                    <InputText v-model="client.nif" id="nif" type="text" />
                </div>
            </div>
        </div>

        <div class="col-12 md:col-6">
            <div class="card p-fluid">
                <div class="field">
                    <label for="telefon1">Telèfon</label>
                    <InputText v-model="client.telefon" id="telefon1" type="text" />
                </div>
                <div class="field">
                    <label for="telefon2">Telèfon 2</label>
                    <InputText v-model="client.telefon2" id="telefon2" type="text" />
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <InputText v-model="client.email" id="email" type="text" />
                </div>
                <div class="field col-12 md:col-3">
                        <label for="idioma">Idioma</label>
                        <Dropdown  id="idioma" v-model="client.idioma_id" :options="dropdownItems" optionValue="id" optionLabel="name" placeholder="Select One"></Dropdown>
                 </div>
                 <div class="field col-6 md:col-3">
                    <!-- Al no haber fotos, pots enviar la info amb el @click -->
                    <Button @click="addClient" label="Submit"></Button>
                </div>
            </div>
        </div>
    </div>

</template>





<!-- <template>
    <div class="grid">
        <div class="col-12 md:col-6">
            <div class="card p-fluid">
                <h5>Nou Client</h5>
                <div class="field">
                    <label for="name1">Nom</label>
                    <InputText id="name1" type="text" />
                </div>
                <div class="field">
                    <label for="cognom">Cognom</label>
                    <InputText id="cognom" type="text" />
                </div>
                <div class="field">
                    <label for="cognom2">Segon Cognom</label>
                    <InputText id="cognom2" type="text" />
                </div>
                <div class="field">
                    <label for="nif">Nif</label>
                    <InputText id="nif" type="text" />
                </div>
                <div class="field">
                    <label for="telefon1">Telèfon</label>
                    <InputText id="telefon1" type="text" />
                </div>
                <div class="field">
                    <label for="telefon2">Telèfon 2</label>
                    <InputText id="telefon2" type="text" />
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <InputText id="email" type="text" />
                </div>
                <div class="field col-12 md:col-3">
                        <label for="idioma">Idioma</label>
                        <Dropdown id="idioma" v-model="dropdownItem" :options="dropdownItems" optionLabel="name" placeholder="Select One"></Dropdown>
                    </div>
            </div>

            <div class="card p-fluid">
                <h5>Vertical Grid</h5>
                <div class="formgrid grid">
                    <div class="field col">
                        <label for="name2">Name</label>
                        <InputText id="name2" type="text" />
                    </div>
                    <div class="field col">
                        <label for="email2">Email</label>
                        <InputText id="email2" type="text" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 md:col-6">
            <div class="card p-fluid">
                <h5>Horizontal</h5>
                <div class="field grid">
                    <label for="name3" class="col-12 mb-2 md:col-2 md:mb-0">Name</label>
                    <div class="col-12 md:col-10">
                        <InputText id="name3" type="text" />
                    </div>
                </div>
                <div class="field grid">
                    <label for="email3" class="col-12 mb-2 md:col-2 md:mb-0">Email</label>
                    <div class="col-12 md:col-10">
                        <InputText id="email3" type="text" />
                    </div>
                </div>
            </div>

            <div class="card">
                <h5>Inline</h5>
                <div class="formgroup-inline">
                    <div class="field">
                        <label for="firstname1" class="p-sr-only">Firstname</label>
                        <InputText id="firstname1" type="text" placeholder="Firstname" />
                    </div>
                    <div class="field">
                        <label for="lastname1" class="p-sr-only">Lastname</label>
                        <InputText id="lastname1" type="text" placeholder="Lastname" />
                    </div>
                    <Button label="Submit"></Button>
                </div>
            </div>

            <div class="card">
                <h5>Help Text</h5>
                <div class="field p-fluid">
                    <label for="username">Username</label>
                    <InputText id="username" type="text" />
                    <small>Enter your username to reset your password.</small>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <h5>Advanced</h5>
                <div class="p-fluid formgrid grid">
                    <div class="field col-12 md:col-6">
                        <label for="firstname2">Firstname</label>
                        <InputText id="firstname2" type="text" />
                    </div>
                    <div class="field col-12 md:col-6">
                        <label for="lastname2">Lastname</label>
                        <InputText id="lastname2" type="text" />
                    </div>
                    <div class="field col-12">
                        <label for="address">Address</label>
                        <Textarea id="address" rows="4" />
                    </div>
                    <div class="field col-12 md:col-6">
                        <label for="city">City</label>
                        <InputText id="city" type="text" />
                    </div>
                    <div class="field col-12 md:col-3">
                        <label for="state">State</label>
                        <Dropdown id="state" v-model="dropdownItem" :options="dropdownItems" optionLabel="name" placeholder="Select One"></Dropdown>
                    </div>
                    <div class="field col-12 md:col-3">
                        <label for="zip">Zip</label>
                        <InputText id="zip" type="text" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template> -->
