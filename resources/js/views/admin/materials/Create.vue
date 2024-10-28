<script setup>
import { ref } from 'vue';

const dropdownItems = ref([
    { name: 'Option 1', id: '1' },
    { name: 'Option 2', id: '2' },
    { name: 'Option 3', id: '3' }
]);

const dropdownItem = ref(null);
const material = ref({});

function addMaterial() {
    console.log('clic');
    axios.post('/api/materials',material.value)
    .then(response =>{
                console.log(response);
                //material.value = response.data;
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
                <h5>Nou material</h5>
                <div class="field">
                    <label for="codigo">Codigo</label>
                    <InputText  v-model="material.codigo" id="codigo" type="text" />
                </div>
               
                <div class="field">
                    <label for="description">Description</label>
                    <InputText v-model="material.description" id="description" type="text" />
                </div>
                
         </div> 
            
        </div>

        <div class="col-12 md:col-6">
            <div class="card p-fluid">
                <div class="field">
                    <label for="stock">Stock</label>
                    <InputText v-model="material.stock"id="stock" type="text" />
                </div>
                <div class="field">
                    <label for="numero_serie">numero_serie</label>
                    <InputText v-model="material.numero_serie"id="numero_serie" type="text" />
                </div> 
                <div class="field">
                    <label for="pvp">PVP</label>
                    <InputText  v-model="material.pvp" id="pvp" type="text" />
                </div>
                <div class="field">
                    <label for="preciocoste">Precio Coste</label>
                    <InputText v-model="material.preciocoste" id="preciocoste" type="text" />
                </div>
                <div class="field">
                    <label for="encurs">enCurs</label>
                    <Checkbox v-model="material.encurs" :binary="true" />
                    <!-- <InputText v-model="proveidor.encurs" id="encurs" type="text" />  -->
                </div>
                <div class="field">
                    <label for="observacions">Observacions</label>
                    <InputText v-model="material.observacions" id="observacions" type="text" />
                </div>
                <div class="field col-6 md:col-3">
                    <!-- Al no haber fotos, pots enviar la info amb el @click -->
                    <Button @click="addMaterial" label="Submit"></Button>
                </div>
            </div>

        </div>

      
    </div>
</template>