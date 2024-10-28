<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Llista de Clients</h5>
                        <div>
                            <router-link :to="{ name: 'clients.create' }" class="btn btn-success">Nou Client</router-link>
                            <!--button class="btn btn-success" type="button">Nueva Tarea</button-->
                        </div>
                    </div>



                    <!-- mostrar varible por pantalla : {{ test }}
                    {{ clients }} -->
                    <DataTable :value="clients" tableStyle="min-width: 50rem">
                        <Column field="nif" header="nif"></Column>
                        <Column field="name" header="Nom"></Column>
                        <Column field="surname1" header="Cognom"></Column>
                        <Column field="surname2" header="Cognom2"></Column>
                        <Column field="telefon" header="Telèfon"></Column>
                        <Column field="email" header="email"></Column>
                        <Column field="idioma.idioma" header="Idioma"></Column>

                        <Column header="Accions">
                            <template #body="slotProps">
                            <!-- Botón para editar asistencia que le pasaremos a la vista edit los datos a través de su id-->
                            <router-link
                                :to="{ name: 'clients.index', params: { id: 1 } }"
                                    class="btn btn-success mr-2"> Editar
                                </router-link>
                                <router-link
                                :to="{ name: 'clients.index', params: { id: 1 } }"
                                    class="btn btn-danger"> Esborrar
                                </router-link>
                            </template>
                        </Column>

                    </DataTable>


                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, onMounted } from "vue";
const clients = ref()

//el que hi ha dins del onmounted es una funció anònima ()=>
onMounted(() => {

    //console.log('Hola que tal')
    axios.get('/api/clients')
        .then(response => {
            console.log(response);
            clients.value = response.data;
        })

})



</script>


<style></style>
