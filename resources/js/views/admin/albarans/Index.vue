<script setup>
import { FilterMatchMode } from 'primevue/api';
import { onMounted, ref } from 'vue';
//import { NodeService } from '@/service/NodeService';
import { useToast } from 'primevue/usetoast';
import Message from 'primevue/message';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';


//const selectedProducts = ref(null);

//const dt = ref(null);
const toast = useToast();
const albarans = ref(null);
const albaranDialog = ref(false);
const deleteAlbaranDialog = ref(false);
//const deleteAlbaransDialog = ref(false);
//const  AlbaranDeleteAlert = ref(false);
const albaran = ref({});
const filters = ref({});
const submitted = ref(false);
const albaranToDelete = ref({});
const indexToDelete = ref(-1);
//const dropdownItem = ref(null);
const dialogHeaderText = ref("");
const showAddButton = ref(true);
const showUpdateButton = ref(false);
const hideDialog = () => {
    albaranDialog.value = false;
    submitted.value = false;
};
const openEdit = (albaranToEdit) => {
    albaranDialog.value = true
    //albaran.value =albaranToEdit ;
    albaran.value = JSON.parse(JSON.stringify({ ...albaranToEdit }));
    dialogHeaderText.value = "Editar Albaran";
    showUpdateButton.value = true;
    showAddButton.value = false;
}
const confirmDeleteAlbaran = () => {
    console.log(albaranToDelete.value.id);
    axios.delete('/api/albarans/' + albaranToDelete.value.id)
        .then(response => {
            albarans.value.splice(indexToDelete.value, 1)
            deleteAlbaranDialog.value = false;
            toast.add({ severity: 'sucess', summary: 'Successful', detail: 'albaran Esborrat', life: 3000 });
        })
}

const deleteAlbaran = (albaran, index) => {
    deleteAlbaranDialog.value = true
    indexToDelete.value = index;
    albaranToDelete.value = albaran;
}

const openNew = () => {
    albaran.value = {};
    //submitted.value = false;
    albaranDialog.value = true;
    dialogHeaderText.value = "Nou albarans";
    showUpdateButton.value = false;
    showAddButton.value = true;
};

function addAlbaran() {
    console.log('clic');
    axios.post('/api/albarans', albaran.value)
        .then(response => {
            console.log(response);
            albarans.value.push(response.data.data)
            console.log(response.data.data);
            albaranDialog.value = false
            //proveidor.value = response.data;
        })
        .catch(error => {
            console.log(error);
        })
}
function updateAlbaran() {
    axios.put('/api/albarans/' + albaran.value.id, albaran.value)
        .then(response => {

            replaceResult(albaran.value.id, response.data.data)
            albaranDialog.value = false
        }).catch(error => {
            console.log(error);
        })
}
function replaceResult(id, newValue) {

    const index = albarans.value.findIndex(albaran => albaran.id === id);
    if (index !== -1) {
        albarans.value[index] = newValue;
        console.log(`Objeto con ID ${id} reemplazado con éxito.`);
    } else {
        console.log(`No se encontró ningún objeto con ID ${id}. No se realizó ningún reemplazo.`);
    }
}
onMounted(() => {
    axios.get('/api/albarans')
        .then(response => {
            console.log(response);
            albarans.value = response.data;
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });
});
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};

initFilters();

const clearFilter = () => {
    initFilters();
};
const dropZoneActive = ref(true)
</script>


<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">

                <!--Toolbar amb botons NEW i EXPORT-->
                <Toolbar class="mb-4">
                    <template v-slot:start>
                        <div class="my-2">
                            <router-link :to="{ name: 'albarans.create' }" @click.native="openNew">
                                <Button label="Nou Albarà" icon="pi pi-plus" class="mr-2" severity="success" />
                            </router-link>

                            <!--<Button label="New" icon="pi pi-plus" class="mr-2" severity="success" @click="openNew" />-->
                        </div>
                    </template>

                    <template v-slot:end>
                        <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
                    </template>
                </Toolbar>


                <DataTable v-model:filters="filters" :value="albarans" dataKey="id" :paginator="true" :rows="10"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Albarans del {first} a {last} of {totalRecords} albarans actius"
                    :globalFilterFields="['ordenes_trabajo_id','clients_id', 'titulo', 'descripcion','precio',]">

                    <!-- BUSCADOR DE ALBARANS -->
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Llistat d'Albarans</h5>

                            <IconField iconPosition="left">
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText v-model="filters['global'].value" placeholder="Buscar" /><Button
                                    type="button" icon="pi pi-filter-slash" label="Neteja" outlined
                                    @click="clearFilter()" />
                            </IconField>
                        </div>
                    </template>

                    <!-- HEADER CAMPS QUE ES MOSTREN -->
                    <Column field="checkbox" header="Selecciona" :sortable="true"
                        headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <Checkbox v-model="slotProps.data.checked" binary variant="filled" />
                        </template>
                    </Column>
                    <Column field="ordenes_trabajo_id" header="Ordre Treball" :sortable="true"
                        headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Id ordre treball</span>
                            {{ slotProps.data.ordenes_trabajo_id }}
                        </template>
                    </Column>
                    <Column field="clients_id" header="Client" :sortable="true"
                        headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Id clients</span>
                            {{ slotProps.data.clients_id }}
                        </template>
                    </Column>
                    <Column field="titulo" header="Títol" :sortable="true" headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Titol</span>
                            {{ slotProps.data.titulo }}
                        </template>
                    </Column>
                    <Column field="precio_id" header="Preu" :sortable="true" headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Preu</span>
                            {{ slotProps.data.precio_id }}
                        </template>
                    </Column>
                    <Column field="descuentos_id" header="Descomptes" :sortable="true"
                        headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Descomptes</span>
                            {{ slotProps.data.descuentos_id }}
                        </template>
                    </Column>

                    <Column field="acciones" header="Accions" :sortable="false" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded
                                @click="openEdit(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded
                                @click="deleteAlbaran(slotProps.data, slotProps.index)" />
                        </template>
                    </Column>
                </DataTable>




                <!-- DIALOG PER CREAR NOU ALBARÀ -->

                <!-- <Dialog v-model:visible="albaranDialog" :style="{ width: '1200px' }" :header="dialogHeaderText"
                    :modal="true" class="p-fluid">
                    <img :src="'/demo/images/product/' + product.image" :alt="product.image" v-if="product.image" width="150" class="mt-0 mx-auto mb-5 block shadow-2" />
                    <div class="card p-fluid">
                        <div class="p-fluid formgrid grid">

                            <div class="field">
                                <label for="titulo">Titulo</label>
                                <InputText v-model="albaran.titulo" id="titulo" type="text" />
                            </div>
                            <div class="field">
                                <label for="descripcion">Descripcion</label>
                                <InputText v-model="albaran.descripcion" id="descripcion" type="text" />
                            </div>
                            <div class="field">
                                <label for="descuentos_id">Descuentos</label>
                                <InputText v-model="albaran.descuentos_id" id="descuentos" type="text" />
                            </div>
                            <div class="field">
                                <label for="observacions">Observacions</label>
                                <InputText v-model="albaran.observacions" id="observacions" type="text" />
                            </div>
                            <div class="field">
                                <label for="precio_id">Precio</label>
                                <InputText v-model="albaran.precio_id" id="precio" type="text" />
                            </div>
                            <div class="field">
                                <label for="iva">Iva</label>
                                <InputText v-model="albaran.iva" id="iva" type="text" />
                            </div>
                            <div class="field">
                                <label for="clients_id">Id clients </label>
                                <InputText id="clients_id" v-model.trim="albaran.clients_id" type="text" />

                            </div>
                            <div class="field">
                                <label for="ordenes_trabajo_id">Id orden trabajo </label>
                                <InputText id="ordenes_trabajo_id" v-model.trim="albaran.ordenes_trabajo_id"
                                    type="text" />

                            </div>
                        </div>
                    </div>
                            <template #footer>
                                <Button label="Cancel.la" icon="pi pi-times" text="" @click="hideDialog" />
                                <Button v-if="showAddButton" @click="addAlbaran" label="Guardar" icon="pi pi-check"
                                    text="" />
                                <Button v-if="showUpdateButton" @click="updateAlbaran" label="Actualitzar"
                                    icon="pi pi-check" text="" />
                            </template>
                </Dialog> -->


                <!-- DIALOG PER ESBORRAR  ALBARANS -->

                <Dialog v-model:visible="deleteAlbaranDialog" :style="{ width: '450px' }" header="Confirma" modal>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="product"> Esborrar Albaran <b>{{albaranToDelete.name }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteAlbaranDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteAlbaran" />
                    </template>
                </Dialog>

                <!-- <Dialog v-model:visible="deleteProveidorsDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteProveidorsDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteProveidor" />
                    </template>
                </Dialog> -->

            </div>
        </div>
    </div>
</template>
