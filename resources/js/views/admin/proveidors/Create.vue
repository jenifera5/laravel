<script setup>
import { ref } from 'vue';

const dropdownItems = ref([
    { name: 'Option 1', id: '1' },
    { name: 'Option 2', id: '2' },
    { name: 'Option 3', id: '3' }
]);

const dropdownItem = ref(null);
const proveidor = ref({});

function addProveidor() {
    console.log('clic');
    axios.post('/api/proveidors',proveidor.value)
    .then(response =>{
                console.log(response);
                //proveidor.value = response.data;
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
                <h5>Nou Proveidor</h5>
                <div class="field">
                    <label for="name">Nom</label>
                    <InputText  v-model="proveidor.name" id="name" type="text" />
                </div>
                <div class="field">
                    <label for="nif">Nif</label>
                    <InputText v-model="proveidor.nif" id="nif" type="text" />
                </div>
                
         </div> 
            
        </div>

        <div class="col-12 md:col-6">
            <div class="card p-fluid">
                <div class="field">
                    <label for="telefon">Telefon</label>
                    <InputText v-model="proveidor.telefon"id="telefon" type="text" />
                </div>
                <div class="field">
                    <label for="telefon2">Telefon2</label>
                    <InputText v-model="proveidor.telefon2"id="telefon2" type="text" />
                </div> 
                <div class="field">
                    <label for="email">Email</label>
                    <InputText  v-model="proveidor.email" id="email" type="text" />
                </div>
                <div class="field">
                    <label for="contacte">contacte</label>
                    <InputText v-model="proveidor.contacte" id="contacte" type="text" />
                </div>
                <div class="field">
                    <label for="encurs">enCurs</label>
                    <Checkbox v-model="proveidor.encurs" :binary="true" />
                    <!-- <InputText v-model="proveidor.encurs" id="encurs" type="text" />  -->
                </div>
                <div class="field">
                    <label for="diacobrament">diaCobrament</label>
                    <InputText v-model="proveidor.diacobrament" id="diacobrament" type="text" />
                </div>
                <div class="field">
                    <label for="observacions">Observacions</label>
                    <InputText v-model="proveidor.observacions" id="obsevacions" type="text" />
                </div>
                <div class="field col-6 md:col-3">
                    <!-- Al no haber fotos, pots enviar la info amb el @click -->
                    <Button @click="addProveidor" label="Submit"></Button>
                </div>
            </div>

        </div>

      
    </div>
</template>