<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una tarea nueva</h5>
            </div>


            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong></strong>
            </div>


            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong></strong>
            </div>

            <!--Mostrar tasca a la pantalla-->
            <!--{{ tarea }}-->

            <!--Enviar amb el botó submit la info del form-->
            <form @submit.prevent="addTask">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="tarea.name" type="text" class="form-control" placeholder="Nombre tarea">
                </div>


                <div class="form-group mb-2">
                    <label>Descripción</label><span class="text-danger"> *</span>
                    <textarea v-model="tarea.description" class="form-control" rows="3"
                        placeholder="Descripción"></textarea>
                </div>



                <div class="form-gorup mb-2">
                    <label>Fecha inicio</label><span class="text-danger">*</span>
                    <input v-model="tarea.date_open" class="form-control" type="date" name="date_open" />
                </div>


                <div class="form-gorup mb-2">
                    <label>Fecha fin</label><span class="text-danger">*</span>
                    <input v-model="tarea.date_close" class="form-control" type="datetime-local" name="date_close" />
                </div>



                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir Tarea</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import { ref } from "vue";


const tarea = ref({});

function addTask() {
    //console.log('clic');
    axios.post('/api/tasks',tarea.value)
    .then(response =>{
                console.log(response);
                //tasks.value = response.data;
            })
            .catch(error=>{
                console.log(error);
            })


}


</script>


<style></style>
